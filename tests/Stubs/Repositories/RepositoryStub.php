<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Repositories;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;

class RepositoryStub implements RepositoryInterface
{
    /**
     * Entity.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    private $entity;

    /**
     * Construct repository stub.
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
    public function findAll(): array
    {
        return [$this->entity];
    }

    /**
     * @inheritdoc
     */
    public function findById(string $entityId): EntityInterface
    {
        return $this->entity;
    }
}
