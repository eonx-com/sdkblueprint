<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

class EmptyAttributesException extends SdkBlueprintException
{
    public function getErrorSubCode(): int
    {
        return 2;
    }
}
