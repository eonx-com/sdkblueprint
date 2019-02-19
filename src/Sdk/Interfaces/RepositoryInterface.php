<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RepositoryInterface
{
    /**
     * Find all entities.
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface[]
     */
    public function findAll(): array;

    /**
     * Find entity by id.
     *
     * @param string $id Entity id
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function findById(string $id): EntityInterface;
}
