<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use EoneoPay\Utils\Exceptions\ValidationException;

/**
 * An exception that is thrown when the request action does not exist under an entities supported URIs.
 */
final class InvalidUriActionException extends ValidationException
{
    /**
     * @inheritdoc
     */
    public function getErrorCode(): int
    {
        return self::DEFAULT_ERROR_CODE_VALIDATION;
    }

    /**
     * @inheritdoc
     */
    public function getErrorSubCode(): int
    {
        return self::DEFAULT_ERROR_SUB_CODE + 1;
    }
}
