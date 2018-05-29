<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

class UndefinedMethodException extends SdkBlueprintException
{
    /**
     * {@inheritdoc}
     */
    public function getErrorSubCode(): int
    {
        return 4;
    }
}
