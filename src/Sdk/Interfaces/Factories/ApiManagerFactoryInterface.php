<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;

interface ApiManagerFactoryInterface
{
    /**
     * Create api manager instance.
     *
     * @param string $baseUri Base uri used by api manager
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface
     */
    public function create(string $baseUri): ApiManagerInterface;
}
