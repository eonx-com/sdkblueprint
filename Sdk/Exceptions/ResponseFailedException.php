<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

class ResponseFailedException extends SdkBlueprintException
{
    /**
     * {@inheritdoc}
     */
    public function getErrorSubCode(): int
    {
        return 2;
    }
}
