<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Managers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Repositories\RepositoryStub;

/**
 * @coversNothing
 */
class ApiManagerStub implements ApiManagerInterface
{
    /**
     * Entity.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    private $entity;

    /**
     * Construct api manager stub.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface|null $entity
     */
    public function __construct(?EntityInterface $entity = null)
    {
        $this->entity = $entity ?? new EntityStub();
    }

    /**
     * @inheritdoc
     */
    public function findAll(string $entityName): array
    {
        return [$this->entity];
    }

    /**
     * @inheritdoc
     */
    public function find(string $entityName, string $entityId): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @inheritdoc
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function update(EntityInterface $entity): EntityInterface
    {
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function delete(EntityInterface $entity): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getRepository(string $entityClass): RepositoryInterface
    {
        return new RepositoryStub($this->entity);
    }
}
