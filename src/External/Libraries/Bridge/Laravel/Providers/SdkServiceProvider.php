<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\External\Libraries\Bridge\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use LoyaltyCorp\SdkBlueprint\Sdk\ApiManager;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\ExceptionFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\ExceptionFactoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\SerializerFactoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;

class SdkServiceProvider extends ServiceProvider
{
    /**
     * Register gateway drivers
     *
     * @return void
     */
    public function register(): void
    {
        // bind manager
        $this->app->bind(ApiManagerInterface::class, ApiManager::class);

        // bind factories
        $this->app->bind(SerializerFactoryInterface::class, SerializerFactory::class);

        // bind handlers
        $this->app->bind(RequestHandlerInterface::class, RequestHandler::class);
    }
}
