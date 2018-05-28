<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

abstract class ExceptionTestCase extends TestCase
{
    abstract protected function getExceptionClass(): string;
    abstract protected function getExpectSubCode(): int;

    public function testRun(): void
    {
        $class = $this->getExceptionClass();
        self::assertSame($this->getExpectSubCode(), (new $class)->getErrorSubCode());
    }
}