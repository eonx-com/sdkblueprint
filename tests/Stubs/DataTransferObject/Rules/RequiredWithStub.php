<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class RequiredWithStub extends BaseStub
{
    protected function hasAttributes(): array
    {
        return \array_merge(parent::hasAttributes(), ['inclusive_attribute']);
    }

    protected function getRuleString(): string
    {
        return 'requiredWith:inclusive_attribute';
    }
}
