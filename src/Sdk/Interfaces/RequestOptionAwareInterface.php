<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestOptionAwareInterface
{
    /**
     * Set options if request object needs.
     *
     * @return mixed[]
     */
    public function options(): array;
}
