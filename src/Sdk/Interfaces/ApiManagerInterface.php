<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface ApiManagerInterface
{
    /**
     * Request to create an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function create(EntityInterface $entity): EntityInterface;

    /**
     * Request to delete an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return bool
     */
    public function delete(EntityInterface $entity): bool;

    /**
     * Request to find an entity.
     *
     * @param string $entityName Entity class name
     * @param string $entityId Entity id
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function find(string $entityName, string $entityId): EntityInterface;

    /**
     * Request to find all entity of a type.
     *
     * @param string $entityName Entity class name
     *
     * @return mixed[]
     */
    public function findAll(string $entityName): array;

    /**
     * Get entity repository.
     *
     * @param string $entityClass
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface
     */
    public function getRepository(string $entityClass): RepositoryInterface;

    /**
     * Request to update an entity.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function update(EntityInterface $entity): EntityInterface;
}
