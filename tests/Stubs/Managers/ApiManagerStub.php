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
    public function create(string $apikey, EntityInterface $entity): EntityInterface
    {
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function delete(string $apikey, EntityInterface $entity): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function find(string $entityName, string $entityId, string $apikey): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @inheritdoc
     */
    public function findAll(string $entityName, string $apikey): array
    {
        return [$this->entity];
    }

    /**
     * @inheritdoc
     */
    public function getRepository(string $entityClass): RepositoryInterface
    {
        return new RepositoryStub($this->entity);
    }

    /**
     * @inheritdoc
     */
    public function update(string $apikey, EntityInterface $entity): EntityInterface
    {
        return $entity;
    }
}
