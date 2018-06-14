<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\ExceptionFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\CriticalException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\NotFoundException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\ExceptionFactory
 */
class ExceptionFactoryTest extends TestCase
{
    /**
     * Make sure the exception object has the expected type.
     *
     * @return void
     */
    public function testCreate(): void
    {
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(CriticalException::class, (new ExceptionFactory('', 1999))->create());
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(ValidationException::class, (new ExceptionFactory('', 1000))->create());
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(RuntimeException::class, (new ExceptionFactory('', 1100))->create());
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(NotFoundException::class, (new ExceptionFactory('', 1499))->create());
    }
}
