<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
 */
class ResponseFailedExceptionTest extends TestCase
{
    public function testGetMethods(): void
    {
        $exception = new ResponseFailedException('error message', 1111, 400, 1);
        self::assertSame('error message', $exception->getMessage());
        self::assertSame(1111, $exception->getErrorCode());
        self::assertSame(400, $exception->getStatusCode());
        self::assertSame(1, $exception->getErrorSubCode());
    }
}
