<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface AssemblableObjectInterface
{
    /**
     * Set embedded data transfer objects for a request action.
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject[]
     */
    public function embedObjects(): array;
}
