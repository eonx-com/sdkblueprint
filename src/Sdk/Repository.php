<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    /**
     * Sdk api manager.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface
     */
    private $apiManager;

    /**
     * Construct api repository.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface $apiManager
     */
    public function __construct(ApiManagerInterface $apiManager)
    {
        $this->apiManager = $apiManager;
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
