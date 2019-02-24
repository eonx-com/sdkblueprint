<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;

interface RequestHandlerInterface extends RequestAwareInterface
{
    /**
     * Make a request to create an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function create(EntityInterface $entity, ?string $apikey = null): EntityInterface;

    /**
     * Make a request to delete an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return bool
     */
    public function delete(EntityInterface $entity, ?string $apikey = null): bool;

    /**
     * Make a request to fetch an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function get(EntityInterface $entity, ?string $apikey = null): EntityInterface;

    /**
     * Make a request to list entities.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface[]
     */
    public function list(EntityInterface $entity, ?string $apikey = null): array;

    /**
     * Make a request to update an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function update(EntityInterface $entity, ?string $apikey = null): EntityInterface;
}
