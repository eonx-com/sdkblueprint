<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
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
        ?SerializerInterface $serializer,
        ?ValidatorInterface $validator
    ) {
        $this->client = $client ?? new GuzzleClient();
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function create(RequestInterface $request)
    {
        return $this->send($request, 'POST');
    }

    public function update(RequestInterface $request)
    {
        return $this->send($request, 'PUT');
    }

    public function delete(RequestInterface $request)
    {
        return $this->send($request, 'DELETE');
    }

    private function send(RequestInterface $request, string $method)
    {
        if ($request->expectObject() === null |
            ($this->serializer instanceof SerializerInterface) === false
        ) {
            throw new \Exception('client can not populate the response back to object.');
        }

        $response = $this->request($request, $method);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new ResponseFailedException($response->getMessage());
        }

        return $this->serializer->deserialize($response->getContent(), $request->expectObject(), 'json');
    }

    /**
     * Send HTTP request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface $request
     * @param string $method
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     */
    private function request(RequestInterface $request, string $method): ResponseInterface
    {
        try {
            if ($this->validator instanceof ValidatorInterface) {
                $errors = $this->validator->validate($request, null, $request->getValidationGroups());

                if (\count($errors) > 0) {
                    $errorMessage = null;
                    foreach ($errors as $error) {
                        $errorMessage .= $error->getPropertyPath(). ': ' .$error->getMessage();
                    }

                    throw new InvalidRequestDataException($errorMessage);
                }
            }

            /** @noinspection PhpUnhandledExceptionInspection all exception will be caught*/
            $response = $this->client->request($method, $request->getUri(), $request->getOptions());
        } catch (RequestException $exception) {
            return (new ResponseFactory())->createErrorResponse($exception);
        }

        return (new ResponseFactory())->createSuccessfulResponse($response);
    }
}
