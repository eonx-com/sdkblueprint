<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

abstract class BaseStub extends DataTransferObject
{
    protected function hasAttributes(): array
    {
        return [ValidationTestCase::ATTRIBUTE];
    }

    public function hasValidationRules(): array
    {
        return [ValidationTestCase::ATTRIBUTE => $this->getRuleString()];
    }

    abstract protected function getRuleString(): string;
}
