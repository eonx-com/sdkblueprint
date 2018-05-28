<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class InvalidArgumentExceptionTest extends ExceptionTestCase
{
    protected function getExceptionClass(): string
    {
        return InvalidArgumentException::class;
    }

    protected function getExpectSubCode(): int
    {
        return 2;
    }
}
