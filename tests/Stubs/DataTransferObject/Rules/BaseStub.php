<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren) child classes are required by tests.
 */
abstract class BaseStub extends DataTransferObject
{
    /**
     * @inheritdoc
     */
    protected function hasAttributes(): array
    {
        return [ValidationTestCase::ATTRIBUTE];
    }

    /**
     * @inheritdoc
     */
    public function hasValidationRules(): array
    {
        return [ValidationTestCase::ATTRIBUTE => $this->getRuleString()];
    }

    /**
     * Get validation rule string.
     *
     * @return string
     */
    abstract protected function getRuleString(): string;
}
