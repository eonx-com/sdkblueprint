<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

abstract class ExceptionTestCase extends TestCase
{
    /**
     * The exception class full namespace.
     *
     * @return string
     */
    abstract protected function getExceptionClass(): string;

    /**
     * The exception sub code.
     *
     * @return int
     */
    abstract protected function getExpectSubCode(): int;

    /**
     * Run the tests.
     *
     * @return void
     */
    public function testRun(): void
    {
        $class = $this->getExceptionClass();
        self::assertSame($this->getExpectSubCode(), (new $class)->getErrorSubCode());
    }
}
