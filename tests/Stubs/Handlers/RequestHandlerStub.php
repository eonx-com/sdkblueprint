<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;

/**
 * @coversNothing
 */
class RequestHandlerStub implements RequestHandlerInterface
{
    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    private $entity;

    /**
     * Construct request handler stub.
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
    public function create(EntityInterface $entity, ?string $apikey = null): EntityInterface
    {
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function delete(EntityInterface $entity, ?string $apikey = null): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function get(EntityInterface $entity, ?string $apikey = null): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @inheritdoc
     */
    public function list(EntityInterface $entity, ?string $apikey = null): array
    {
        return [$this->entity];
    }

    /**
     * @inheritdoc
     */
    public function update(EntityInterface $entity, ?string $apikey = null): EntityInterface
    {
        return $entity;
    }
}
