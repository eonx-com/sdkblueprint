<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestOptionAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;
use LoyaltyCorp\SdkSpecification\Interfaces\RequestInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestAdapter implements RequestInterface
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function uri(): string
    {
        $uris = $this->object->uris();

        if (isset($uris[$this->requestMethod]) === false) {
            throw new InvalidRequestUriException(\sprintf('no uri exists for %s method', $this->requestMethod));
        }

        return $uris[$this->requestMethod];
    }

    /**
     * Validate the request object.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     */
    public function validate(): void
    {
        $errors = $this->validator->validate($this->object, null, $this->validationGroup());

        if (\count($errors) > 0) {
            $errorMessage = null;
            foreach ($errors as $error) {
                $errorMessage .= $error->getPropertyPath(). ': ' .$error->getMessage();
            }

            throw new InvalidRequestDataException($errorMessage);
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
        if ($this->object instanceof RequestValidationGroupAwareInterface) {
            return $this->object->validationGroups();
        }

        return [$this->requestMethod];
    }

    /**
     * Get serialization group.
     *
     * @return string[]
     */
    private function serializationGroup(): array
    {
        if ($this->object instanceof RequestSerializationGroupAwareInterface) {
            return $this->object->serializationGroup();
        }

        return [$this->requestMethod];
    }
}
