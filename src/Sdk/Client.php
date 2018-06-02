<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Client
{
    /**
     * Guzzle HTTP client for requests
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * Validator.
     *
     * @var null|\Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * Instantiate the attributes.
     *
     * @param null|GuzzleClient $client
     * @param null|Serializer $serializer
     * @param null|ValidatorInterface $validator
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(
        ?GuzzleClient $client = null,
        ?Serializer $serializer = null,
        ?ValidatorInterface $validator = null
    ) {
        $this->client = $client ?? new GuzzleClient();
        $this->serializer = $serializer ?? (new SerializerFactory())->create();
        $this->validator = $validator ?? (new ValidatorFactory())->create();
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return object
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function create(RequestObjectInterface $request)
    {
        return $this->sendRequest($request, 'POST', RequestMethodInterface::CREATE);
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return object
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function delete(RequestObjectInterface $request)
    {
        return $this->sendRequest($request, 'DELETE', RequestMethodInterface::DELETE);
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return object
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function list(RequestObjectInterface $request)
    {
        return $this->sendRequest($request, 'GET', RequestMethodInterface::LIST);
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return object
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function update(RequestObjectInterface $request)
    {
        return $this->sendRequest($request, 'PUT', RequestMethodInterface::UPDATE);
    }

    private function sendRequest(RequestObjectInterface $request, string $httpMethod, string $requestMethod)
    {
        $uris = $request->uris();
        if (isset($uris[$requestMethod]) === false) {
            throw new InvalidRequestUriException('Uri of deletion is required.');
        }

        $uri = $uris[$requestMethod];

        $options = \array_merge(
            $request->options(),
            [
                'json' => $this->serializer->normalize($request, null, ['groups' => [$requestMethod]])
            ]
        );

        return $this->send($request, $httpMethod, $uri, $options, $requestMethod);
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     * @param string $httpMethod
     * @param string $uri
     * @param array|null $options
     * @param string $requestMethod
     *
     * @return object
     *
     * @throws InvalidRequestDataException
     * @throws ResponseFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function send(
        RequestObjectInterface $request,
        string $httpMethod,
        string $uri,
        ?array $options,
        string $requestMethod
    ) {
        if ($request->expectObject() === null) {
            throw new \Exception('client can not populate the response back to object.');
        }

        $response = $this->request($request, $httpMethod, $uri, $options, [$requestMethod]);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new ResponseFailedException($response->getMessage());
        }

        $type = $request->expectObject();
        if ($requestMethod === RequestMethodInterface::LIST) {
            $type = \sprintf('%s[]', $request->expectObject());
        }

        return $this->serializer->deserialize($response->getContent(), $type, 'json');
    }

    /**
     * Send HTTP request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     * @param string $method
     * @param string uri
     * @param null|mixed $options
     * @param null|string[] $validationGroups
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     */
    private function request(
        RequestObjectInterface $request,
        string $method,
        string $uri = null,
        ?array $options = null,
        ?array $validationGroups = null
    ): ResponseInterface {
        try {
            $errors = $this->validator->validate($request, null, $validationGroups);

            if (\count($errors) > 0) {
                $errorMessage = null;
                foreach ($errors as $error) {
                    $errorMessage .= $error->getPropertyPath(). ': ' .$error->getMessage();
                }

                throw new InvalidRequestDataException($errorMessage);
            }

            /** @noinspection PhpUnhandledExceptionInspection all exception will be caught*/
            $response = $this->client->request($method, $uri, $options);
        } catch (RequestException $exception) {
            return (new ResponseFactory())->createErrorResponse($exception);
        }

        return (new ResponseFactory())->createSuccessfulResponse($response);
    }
}
