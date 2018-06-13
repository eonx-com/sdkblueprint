<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
 */
class InvalidRequestUriExceptionTest extends TestCase
{
    /**
     * Make sure the error sub code is expected.
     *
     * @return void
     */
    public function testGetErrorSubCode(): void
    {
        self::assertSame(2, (new InvalidRequestUriException())->getErrorSubCode());
    }
}
