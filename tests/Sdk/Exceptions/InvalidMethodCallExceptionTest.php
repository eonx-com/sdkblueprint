<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidMethodCallException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class InvalidMethodCallExceptionTest extends TestCase
{
    /**
     * Test get error code.
     *
     * @return void
     */
    public function testGetErrorCode(): void
    {
        self::assertSame(
            InvalidMethodCallException::DEFAULT_ERROR_CODE_VALIDATION,
            (new InvalidMethodCallException())->getErrorCode()
        );
    }

    /**
     * Test get error sub code.
     *
     * @return void
     */
    public function testGetErrorSubCode(): void
    {
        self::assertSame(
            InvalidMethodCallException::DEFAULT_ERROR_SUB_CODE,
            (new InvalidMethodCallException())->getErrorSubCode()
        );
    }
}
