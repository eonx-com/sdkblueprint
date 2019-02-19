<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client;
use LoyaltyCorp\SdkBlueprint\Sdk\ApiManager;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Repositories\Repository;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EwalletStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\UserStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Repositories\UserRepositoryStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class RepositoryTest extends TestCase
{
    /**
     * Test that appropriate repository will return if entity is annotated with repository class.
     *
     * @return void
     */
    public function testCustomRepo():  void
    {
        $repository = $this->getApiManager()->getRepository(UserStub::class);

        self::assertInstanceOf(UserRepositoryStub::class, $repository);
    }

    /**
     * Test that appropriate repository will return if entity is annotated with repository class.
     *
     * @return void
     */
    public function testDefaultRepo():  void
    {
        $repository = $this->getApiManager()->getRepository(EwalletStub::class);

        self::assertInstanceOf(Repository::class, $repository);
    }

    /**
     * Get api manager instance.
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface
     */
    private function getApiManager(): ApiManagerInterface
    {
        return new ApiManager(
            new RequestHandler(
                new Client(),
                new SerializerFactory()
            )
        );
    }
}
