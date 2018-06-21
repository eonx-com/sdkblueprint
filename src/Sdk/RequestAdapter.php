<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestOptionAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestAdapter
{
    /**
     * HTTP request method.
     *
     * @var string $httpMethod
     */
    private $httpMethod;

    /**
     * The Request method.
     *
     * @var string $requestMethod
     */
    private $requestMethod;

    /**
     * The Request object instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $object
     */
    private $object;

    /**
     * The Serializer instance.
     *
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * The Validator instance.
     *
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator
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
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     * @param string $format
     *
     * @return mixed returns the object of the expected class.
     */
    public function getObject(?string $responseContents, string $format = 'json')
    {
        return $this->serializer->deserialize($responseContents, $this->deserializeType(), $format);
    }

    /**
     * {@inheritdoc}
     */
    public function method(): string
    {
        return $this->httpMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function options(): array
    {
        $body = [
            'json' => $this->serializer->normalize($this->object, null, ['groups' => $this->serializationGroup()])
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
    public function uri(): string
    {
        $uris = $this->object->uris();

        if (isset($uris[$this->requestMethod]) === false) {
            throw new ValidationException(\sprintf('no uri exists for %s method', $this->requestMethod));
        }

        return $uris[$this->requestMethod];
    }

    /**
     * Validate the request object.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     */
    public function validate(): void
    {
        $errors = $this->validator->validate($this->object, null, $this->validationGroup());

        if (\count($errors) > 0) {
            $errorMessage = null;
            foreach ($errors as $error) {
                $errorMessage .= $error->getPropertyPath(). ': ' .$error->getMessage();
            }

            throw new ValidationException($errorMessage);
        }
    }

    /**
     * Get the type for deserialization.
     *
     * @return string
     */
    private function deserializeType(): string
    {
        $expectObjectClass = $this->object->expectObject();

        return $this->requestMethod === RequestMethodInterface::LIST ?
            \sprintf('%s[]', $expectObjectClass) : $expectObjectClass;
    }

    /**
     * Get validation group.
     *
     * @return string[]
     */
    private function validationGroup(): array
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
    private function serializationGroup(): array
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
