<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface ApiManagerInterface
{
    /**
     * Request to create an entity.
     *
     * @param string $apikey Api key
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function create(string $apikey, EntityInterface $entity): EntityInterface;

    /**
     * Request to delete an entity.
     *
     * @param string $apikey Api key
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return bool
     */
    public function delete(string $apikey, EntityInterface $entity): bool;

    /**
     * Request to find an entity.
     *
     * @param string $entityName Entity class name
     * @param string $apikey Api key
     * @param string $entityId Entity id
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function find(string $entityName, string $apikey, string $entityId): EntityInterface;

    /**
     * Request to find all entity of a type.
     *
     * @param string $entityName Entity class name
     * @param string $apikey Api key
     *
     * @return mixed[]
     */
    public function findAll(string $entityName, string $apikey): array;

    /**
     * Request to find by entity criteria.
     *
     * @param string $entityName Entity class name
     * @param string $apikey Api key
     * @param mixed[] $criteria Entity properties as key value
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface[]
     */
    public function findBy(string $entityName, string $apikey, array $criteria): array;

    /**
     * Request to find by entity criteria.
     *
     * @param string $entityName Entity class name
     * @param string $apikey Api key
     * @param mixed[] $criteria Entity properties as key value
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function findOneBy(string $entityName, string $apikey, array $criteria): EntityInterface;

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
     * @param string $apikey Api key
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function update(string $apikey, EntityInterface $entity): EntityInterface;
}
