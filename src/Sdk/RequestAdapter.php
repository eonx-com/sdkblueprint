<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectOptionAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;
use LoyaltyCorp\SdkSpecification\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkSpecification\Interfaces\RequestInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestAdapter implements RequestInterface
{
    private $httpMethod;
    private $requestMethod;
    private $object;
    private $serializer;
    private $validator;

    public function __construct(
        string $httpMethod,
        string $requestMethod,
        RequestObjectInterface $requestObject,
        Serializer $serializer,
        ValidatorInterface $validator
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
     * @param array $responseContents
     * @param string $format
     *
     * @return object
     */
    public function getObject(array $responseContents, string $format = 'json'): object
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
            'json' => $this->serializer->normalize($this->object, null, ['groups' => [$this->requestMethod]])
        ];

        if ($this->object instanceof RequestObjectOptionAwareInterface) {
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
     * Validate request object.
     *
     * @throws InvalidRequestDataException
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
     * @return array
     */
    private function validationGroup(): array
    {
        if ($this->object instanceof RequestValidationGroupAwareInterface) {
            return $this->object->validationGroups();
        }

        return [$this->requestMethod];
    }
}
