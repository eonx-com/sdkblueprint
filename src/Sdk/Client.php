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

    public function __construct(?GuzzleClient $client, ?ResponseInterface $response)
    {
        $this->client = $client ?? new GuzzleClient();
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection catch block will catch all exception and
     *               this method won't throw any exception.
     *
     * @param RequestInterface $command
     *
     * @return ResponseInterface
     */
    public function request(RequestInterface $command): ResponseInterface
    {
        try {
            /** @noinspection PhpUnhandledExceptionInspection all exception will be caught*/
            $response = $this->client->request($command->getMethod(), $command->getUri(), $command->getOptions());
        } catch (RequestException $exception) {
            return (new ResponseFactory())->createErrorResponse($exception);
        }

        return (new ResponseFactory())->createSuccessfulResponse($response);
    }
}
