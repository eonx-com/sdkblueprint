<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestObjectOptionAwareInterface
{
    /**
     * Set options if request object needs.
     *
     * @return array
     */
    public function options(): array;
}
