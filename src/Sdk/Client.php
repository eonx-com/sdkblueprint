<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ClientInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;

class Client implements ClientInterface
{
    /**
     * Guzzle HTTP client for requests
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Instantiate the object and fill all its attributes by given data.
     *
     * @param null|\GuzzleHttp\Client $client
     */
    public function __construct(?GuzzleClient $client)
    {
        $this->client = $client ?? new GuzzleClient();
    }

    /**
     * @inheritdoc
     */
    public function request(RequestInterface $request): ResponseInterface
    {
        try {
            /** @noinspection PhpUnhandledExceptionInspection all exception will be caught*/
            $response = $this->client->request($request->getMethod(), $request->getUri(), $request->getOptions());
        } catch (RequestException $exception) {
            return (new ResponseFactory())->createErrorResponse($exception);
        }

        return (new ResponseFactory())->createSuccessfulResponse($response);
    }
}
