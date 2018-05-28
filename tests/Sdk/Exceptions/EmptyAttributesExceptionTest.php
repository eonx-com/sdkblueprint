<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class EmptyAttributesExceptionTest extends ExceptionTestCase
{
    protected function getExceptionClass(): string
    {
        return EmptyAttributesException::class;
    }

    protected function getExpectSubCode(): int
    {
        return 1;
    }
}
