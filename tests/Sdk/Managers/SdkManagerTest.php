<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Managers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Managers\SdkManager;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Handlers\RequestHandlerStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Managers\SdkManager
 */
final class SdkManagerTest extends TestCase
{
    /**
     * Test that sdk manager finds and returns array of entities with excepted number of items in it.
     *
     * @return void
     */
    public function testListRequestSuccessfully(): void
    {
        $entities = $this->getManager()->execute(new EntityStub(), RequestAwareInterface::LIST, 'api-key');

        self::assertCount(1, $entities);
        self::assertInstanceOf(EntityStub::class, $entities[0]);
    }

    /**
     * Get api manage instance.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface|null $entity
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkManagerInterface
     */
    private function getManager(?EntityInterface $entity = null): SdkManagerInterface
    {
        return new SdkManager(new RequestHandlerStub($entity));
    }

    /**
     * Test that sdk manager will create an entity successfully.
     *
     * @return void
     */
    public function testCreateRequestSuccessfully(): void
    {
        $entity = new EntityStub(['entityId' => \uniqid('id', false)]);

        $created = $this->getManager($entity)->execute($entity, RequestAwareInterface::CREATE, 'api-key');

        self::assertInstanceOf(EntityStub::class, $created);
        self::assertSame($entity->getEntityId(), $created->getEntityId());
    }
}
