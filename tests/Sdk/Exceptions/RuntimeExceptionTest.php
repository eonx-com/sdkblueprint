<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException
 */
class RuntimeExceptionTest extends TestCase
{
    /**
     * Test get error code.
     *
     * @return void
     */
    public function testGetErrorCode(): void
    {
        self::assertSame(1120, (new RuntimeException('', 1120))->getErrorCode());
    }

    /**
     * Test get error sub code.
     *
     * @return void
     */
    public function testGetErrorSubCode(): void
    {
        self::assertSame(2, (new RuntimeException('', 1120, null, 2))->getErrorSubCode());
    }
}
