<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class InvalidRequestDataExceptionTest extends ExceptionTestCase
{
    /**
     * @inheritdoc
     */
    protected function getExceptionClass(): string
    {
        return InvalidRequestDataException::class;
    }

    /**
     * @inheritdoc
     */
    protected function getExpectSubCode(): int
    {
        return 6;
    }
}
