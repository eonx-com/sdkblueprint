<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
    /**
     * Sdk api manager.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface
     */
    private $apiManager;

    /**
     * Entity class name.
     *
     * @var string
     */
    private $entityClass;

    /**
     * Construct default repository
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface $apiManager
     * @param string $entityClass
     */
    public function __construct(ApiManagerInterface $apiManager, string $entityClass)
    {
        $this->apiManager = $apiManager;
        $this->entityClass = $entityClass;
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        return $this->getApiManager()->findAll($this->entityClass);
    }

    /**
     * @inheritdoc
     */
    public function findById(string $entityId): EntityInterface
    {
        return $this->getApiManager()->find($this->entityClass, $entityId);
    }

    /**
     * Get api manager.
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface
     */
    protected function getApiManager(): ApiManagerInterface
    {
        return $this->apiManager;
    }
}
