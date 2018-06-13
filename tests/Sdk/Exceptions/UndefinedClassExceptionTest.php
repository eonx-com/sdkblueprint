<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedClassException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class UndefinedClassExceptionTest extends TestCase
{
    /**
     * Make sure the error sub code is expected.
     *
     * @return void
     */
    public function testGetErrorSubCode(): void
    {
        self::assertSame(4, (new UndefinedClassException())->getErrorSubCode());
    }
}
