<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

class InvalidBaseUrlException extends SdkBlueprintException
{
    /**
     * Get Error sub-code.
     *
     * @return int
     */
    public function getErrorSubCode(): int
    {
        return 3;
    }
}
