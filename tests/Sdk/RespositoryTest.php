<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Repository;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Managers\ApiManagerStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Repository
 */
class RespositoryTest extends TestCase
{
    /**
     * Test that find by id will return an entity
     *
     * @return void
     */
    public function testFindById(): void
    {
        $entity = $this->getRepository()->findById('entity-id');

        self::assertInstanceOf(EntityStub::class, $entity);
    }

    /**
     * Test that find all will return an array of entities with 1 item in it.
     *
     * @return void
     */
    public function testFindAll(): void
    {
        $entities = $this->getRepository()->findAll();

        self::assertCount(1, $entities);
        self::assertInstanceOf(EntityStub::class, $entities[0]);
    }

    /**
     * Get entity repository.
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface
     */
    private function getRepository(): RepositoryInterface
    {
        return new Repository(new ApiManagerStub(), EntityStub::class);
    }
}
