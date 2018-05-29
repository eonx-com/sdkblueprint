<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException;
use Tests\LoyaltyCorp\SdkBlueprint\ExceptionTestCase;

class EmptyAttributesExceptionTest extends ExceptionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getExceptionClass(): string
    {
        return EmptyAttributesException::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectSubCode(): int
    {
        return 1;
    }
}
