<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use GuzzleHttp\Client as GuzzleClient;
use LoyaltyCorp\SdkBlueprint\Sdk\ApiManager;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\ApiManagerFactoryInterface;

final class ApiManagerFactory implements ApiManagerFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(string $baseUri): ApiManagerInterface
    {
        return new ApiManager(
            new RequestHandler(new GuzzleClient(['base_uri' => $baseUri]),
            new SerializerFactory()
        ));
    }
}
