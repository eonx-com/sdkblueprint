<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\External\Libraries\Bridge\Laravel\Providers;

use Laravel\Lumen\Application;
use LoyaltyCorp\SdkBlueprint\External\Libraries\Bridge\Laravel\Providers\SdkServiceProvider;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\External\Libraries\Bridge\Laravel\Providers\SdkServiceProvider
 */
class SdkServiceProviderTest extends TestCase
{
    /**
     * @var \Laravel\Lumen\Application
     */
    private $app;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->app = new Application();
        $this->app->register(SdkServiceProvider::class);
    }

    /**
     * Test provider registers bindings as expected
     *
     * @return void
     */
    public function testServiceProviderRegistersBindingsInContainer(): void
    {
        self::assertInstanceOf(
            RequestHandler::class,
            $this->app->make(RequestHandlerInterface::class)
        );
    }
}
