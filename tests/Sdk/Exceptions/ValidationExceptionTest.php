<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
 */
class ValidationExceptionTest extends TestCase
{
    /**
     * Test get error code.
     *
     * @return void
     */
    public function testGetErrorCode(): void
    {
        self::assertSame(1000, (new ValidationException('', 1000))->getErrorCode());
    }

    /**
     * Test get error sub code.
     *
     * @return void
     */
    public function testGetErrorSubCode(): void
    {
        self::assertSame(3, (new ValidationException('', 1000, null, null, 3))->getErrorSubCode());
    }
}
