<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class UndefinedValidationRuleExceptionTest extends ExceptionTestCase
{
    /**
     * @inheritdoc
     */
    protected function getExceptionClass(): string
    {
        return UndefinedValidationRuleException::class;
    }

    /**
     * @inheritdoc
     */
    protected function getExpectSubCode(): int
    {
        return 5;
    }
}
