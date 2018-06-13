<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\SdkBlueprintException
 */
class InvalidRequestDataExceptionTest extends TestCase
{
    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     */
    private $exception;

    public function setUp(): void
    {
        parent::setUp();

        $this->exception = new InvalidRequestDataException();
    }

    /**
     * Make sure the error sub code is expected.
     *
     * @return void
     */
    public function testGetErrorSubCode(): void
    {
        self::assertSame(1, $this->exception->getErrorSubCode());
    }

    /**
     * Make sure the error code is expected.
     *
     * @return void
     */
    public function testErrorCode(): void
    {
        self::assertSame(6000, $this->exception->getErrorCode());
    }

    /**
     * Make sure the status code is expected.
     *
     * @return void
     */
    public function testStatusCode(): void
    {
        self::assertSame(500, $this->exception->getStatusCode());
    }
}
