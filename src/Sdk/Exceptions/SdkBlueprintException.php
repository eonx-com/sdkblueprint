<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use EoneoPay\Utils\Exceptions\BaseException;

abstract class SdkBlueprintException extends BaseException
{
    /**
     * Get Error code.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return 6000;
    }

    /**
     * Get Error Response status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return 500;
    }
}
