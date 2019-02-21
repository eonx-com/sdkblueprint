<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Factories\ApiManagerFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Managers\ApiManager;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Factories\ApiManagerFactory
 */
class ApiManagerFactoryTest extends TestCase
{
    /**
     * Test create successfully
     *
     * @return void
     */
    public function testCreate(): void
    {
        $manager = (new ApiManagerFactory())->create('http://localhost');

        self::assertInstanceOf(ApiManager::class, $manager);
    }
}
