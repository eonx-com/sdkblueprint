<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Utils\Str;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestOptionAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestAdapter implements RequestMethodAwareInterface
{
    /**
     * HTTP request method.
     *
     * @var string
     */
    private $httpMethod;

    /**
     * The Request method.
     *
     * @var string
     */
    private $requestMethod;

    /**
     * The Request object instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface
     */
    private $object;

    /**
     * The Serializer instance.
     *
     * @var \Symfony\Component\Serializer\Serializer
     */
    private $serializer;

    /**
     * The Validator instance.
     *
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * Instantiate the attributes.
     *
     * @param string $httpMethod
     * @param string $requestMethod
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $requestObject
     * @param null|\Symfony\Component\Serializer\Serializer $serializer
     * @param null|\Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(
        string $httpMethod,
        string $requestMethod,
        RequestObjectInterface $requestObject,
        ?Serializer $serializer = null,
        ?ValidatorInterface $validator = null
    ) {
        $this->httpMethod = $httpMethod;
        $this->requestMethod = $requestMethod;
        $this->object = $requestObject;
        $this->serializer = $serializer ?? (new SerializerFactory())->create();
        $this->validator = $validator ?? (new ValidatorFactory())->create();
    }

    /**
     * Get the expect object based on the response contents.
     *
     * @param null|string $responseContents
     * @param null|string $format
     *
     * @return mixed returns the object of the expected class.
     */
    public function getObject(?string $responseContents = null, ?string $format = null)
    {
        return $this->serializer->deserialize($responseContents, $this->deserializeType(), $format ?? 'json');
    }

    /**
     * Get the http method of the request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Generate the http options.
     *
     * @return mixed[]
     */
    public function getOptions(): array
    {
        $options = $this->serializer->normalize($this->object, null, ['groups' => $this->getSerializationGroups()]);

        $body = [
            'json' => $this->getFilterOptions($options)
        ];

        if ($this->object instanceof RequestOptionAwareInterface) {
            return \array_merge($this->object->options(), $body);
        }

        return $body;
    }

    /**
     * HTTP request uri.
     *
     * @return string
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     */
    public function getUri(): string
    {
        $uris = $this->object->uris();

        if (isset($uris[$this->requestMethod]) === false) {
            throw new ValidationException(\sprintf('There is no uri specified for %s request', $this->requestMethod));
        }

        return $uris[$this->requestMethod];
    }

    /**
     * Validate the request object.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     */
    public function validate(): void
    {
        $errors = $this->validator->validate($this->object, null, $this->getValidationGroups());

        if (\count($errors) === 0) {
            return;
        }

        $errorMessage = 'Bad request data.';
        $violations = [];
        foreach ($errors as $error) {
            $property = (new Str())->snake($error->getPropertyPath());
            $violations['violations'][$property][] = $error->getMessage();
        }

        throw new ValidationException($errorMessage, null, null, $violations);
    }

    /**
     * Get the type for deserialization.
     *
     * @return string
     */
    private function deserializeType(): string
    {
        $expectObjectClass = $this->object->expectObject();

        return $this->requestMethod === self::LIST ?
            \sprintf('%s[]', $expectObjectClass) : $expectObjectClass;
    }

    /**
     * Recursively filter options array, remove key value pairs when value is null.
     *
     * @param mixed[] $options
     *
     * @return mixed[]
     */
    private function getFilterOptions(array $options): array
    {
        $original = $options;

        $data = \array_filter($options);

        $data = \array_map(function ($element) {
            return \is_array($element) ? $this->getFilterOptions($element) : $element;
        }, $data);

        return $original === $data ? $data : $this->getFilterOptions($data);
    }

    /**
     * Get validation group.
     *
     * @return string[]
     */
    private function getValidationGroups(): array
    {
        $object = $this->object;

        if (($object instanceof RequestValidationGroupAwareInterface) === false) {
            return [$this->requestMethod];
        }

        /** @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface  $object*/
        $groups = $object->validationGroups();

        if (isset($groups[$this->requestMethod]) === false) {
            return [$this->requestMethod];
        }

        return $groups[$this->requestMethod];
    }

    /**
     * Get serialization group.
     *
     * @return string[]
     */
    private function getSerializationGroups(): array
    {
        $object = $this->object;

        if (($object instanceof RequestSerializationGroupAwareInterface) === false) {
            return [$this->requestMethod];
        }

        /** @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface $object */
        $groups = $object->serializationGroup();

        if (isset($groups[$this->requestMethod]) === false) {
            return [$this->requestMethod];
        }

        return $groups[$this->requestMethod];
    }
}
