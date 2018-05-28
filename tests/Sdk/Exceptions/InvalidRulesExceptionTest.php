<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class InvalidRulesExceptionTest extends ExceptionTestCase
{
    protected function getExceptionClass(): string
    {
        return InvalidRulesException::class;
    }

    protected function getExpectSubCode(): int
    {
        return 3;
    }
}
