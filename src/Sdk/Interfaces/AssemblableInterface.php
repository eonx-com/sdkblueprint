<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface AssemblableInterface
{
    /**
     * Set embedded data transfer objects for a request action.
     *
     * @return DataTransferObjectInterface[]
     */
    public function embed(): array;
}
