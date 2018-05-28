<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class SdkBlueprintExceptionTest extends TestCase
{
    /**
     * Test error code and status code.
     *
     * @return void
     */
    public function testGetErrorCode(): void
    {
        self::assertSame(6000, (new EmptyAttributesException())->getErrorCode());
        self::assertSame(500, (new EmptyAttributesException())->getStatusCode());
    }
}
