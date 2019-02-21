<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidApiResponseException;
use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidApiResponseException
 */
class InvalidApiResponseExceptionTest extends TestCase
{
    /**
     * Test that exception has expected code.
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $response = new Response();

        $exception = new InvalidApiResponseException($response);

        self::assertSame(1100, $exception->getErrorCode());
        self::assertSame(1, $exception->getErrorSubCode());
        self::assertSame($response, $exception->getResponse());
    }
}
