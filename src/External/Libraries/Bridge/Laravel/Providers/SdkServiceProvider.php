<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\External\Libraries\Bridge\Laravel\Providers;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\UrnFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\ResponseHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Managers\SdkManager;

class SdkServiceProvider extends ServiceProvider
{
    /**
     * Register services
     *
     * @return void
     */
    public function register(): void
    {
        // bind handlers
        $this->app->singleton(RequestHandlerInterface::class, function () {
            return new RequestHandler(
                new GuzzleClient(['base_uri' => \env('EONEOPAY_API_BASE_URI')]),
                new ResponseHandler(),
                new SerializerFactory(),
                new UrnFactory()
            );
        });

        // bind manager
        $this->app->singleton(SdkManagerInterface::class, SdkManager::class);
    }
}
