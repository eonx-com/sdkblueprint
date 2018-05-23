<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ClientInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\CommandInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkResponseInterface;

class Client implements ClientInterface
{
    /**
     * Guzzle HTTP client for requests
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(?GuzzleClient $client)
    {
        $this->client = $client ?? new GuzzleClient();
    }

    public function request(CommandInterface $command): SdkResponseInterface
    {
        $this->client->request($command->getMethod(), $command->getEndpoint(), $command->getParameters());
    }
}
