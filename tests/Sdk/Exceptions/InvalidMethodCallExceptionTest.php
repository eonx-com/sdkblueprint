<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidMethodCallException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidMethodCallException
 */
final class InvalidMethodCallExceptionTest extends TestCase
{
    /**
     * Test that exception has expected code.
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $exception = new InvalidMethodCallException();

        self::assertSame(1100, $exception->getErrorCode());
        self::assertSame(2, $exception->getErrorSubCode());
    }
}
