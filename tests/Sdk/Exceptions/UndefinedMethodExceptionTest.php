<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedMethodException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class UndefinedMethodExceptionTest extends ExceptionTestCase
{
    protected function getExceptionClass(): string
    {
        return UndefinedMethodException::class;
    }

    protected function getExpectSubCode(): int
    {
        return 4;
    }
}
