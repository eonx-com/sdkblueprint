<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use EoneoPay\Utils\Interfaces\BaseExceptionInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException
 */
final class InvalidUriExceptionTest extends TestCase
{
    /**
     * Test that exception has expected code.
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $exception = new InvalidUriException();

        self::assertSame(BaseExceptionInterface::DEFAULT_ERROR_CODE_VALIDATION, $exception->getErrorCode());
        self::assertSame(0, $exception->getErrorSubCode());
    }
}
