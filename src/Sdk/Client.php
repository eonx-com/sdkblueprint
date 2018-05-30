<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;
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
     * Serializer.
     *
     * @var null|\Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $serializer;

    /**
     * Validator.
     *
     * @var null|\Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * Instantiate the object and fill all its attributes by given data.
     *
     * @param null|\GuzzleHttp\Client $client
     * @param null|\Symfony\Component\Serializer\SerializerInterface $serializer
     * @param null|\Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(
        ?GuzzleClient $client = null,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->client = $client ?? new GuzzleClient();
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function create(RequestObject $request)
    {
        return $this->sendRequest($request, 'POST', RequestMethodInterface::CREATE);
    }

    public function update(RequestObject $request)
    {
        return $this->sendRequest($request, 'PUT', RequestMethodInterface::UPDATE);
    }

    public function delete(RequestObject $request)
    {
        return $this->sendRequest($request, 'DELETE', RequestMethodInterface::DELETE);
    }

    private function sendRequest(RequestObject $request, string $httpMethod, string $requestMethod)
    {
        $uris = $request->getUris();
        $optionCollection = $request->getOptions();
        if (isset($uris[$requestMethod]) === false) {
            throw new InvalidRequestUriException('Uri of deletion is required.');
        }

        $uri = $uris[$requestMethod];
        $options = $optionCollection[$requestMethod] ?? [];

        $validationGroupCollection = $request->getValidationGroups();
        $validationGroup = $validationGroupCollection[$requestMethod] ?? [];
        return $this->send($request, $httpMethod, $uri, $options, $validationGroup);
    }

    /**
     * @param RequestObject $request
     * @param string $method
     * @param string $uri
     * @param array|null $options
     * @return object
     * @throws InvalidRequestDataException
     * @throws ResponseFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function send(RequestObject $request, string $method, string $uri, ?array $options, ?array $validationGroups = null)
    {
        if ($request->expectObject() === null) {
            throw new \Exception('client can not populate the response back to object.');
        }

        $response = $this->request($request, $method, $uri, $options, $validationGroups);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new ResponseFailedException($response->getMessage());
        }

        return $this->serializer->deserialize($response->getContent(), $request->expectObject(), 'json');
    }

    /**
     * Send HTTP request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\RequestObject $request
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
        RequestObject $request,
        string $method,
        string $uri = null,
        ?array $options = null,
        ?array $validationGroups = null
    ): ResponseInterface {
        try {
            if ($this->validator instanceof ValidatorInterface) {
                $errors = $this->validator->validate($request, null, $validationGroups);

                if (\count($errors) > 0) {
                    $errorMessage = null;
                    foreach ($errors as $error) {
                        $errorMessage .= $error->getPropertyPath(). ': ' .$error->getMessage();
                    }

                    throw new InvalidRequestDataException($errorMessage);
                }
            }

            /** @noinspection PhpUnhandledExceptionInspection all exception will be caught*/
            $response = $this->client->request($method, $uri, $options);
        } catch (RequestException $exception) {
            return (new ResponseFactory())->createErrorResponse($exception);
        }

        return (new ResponseFactory())->createSuccessfulResponse($response);
    }
}
