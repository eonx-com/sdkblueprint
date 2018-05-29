<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class RequiredWithStub extends BaseStub
{
    /**
     * {@inheritdoc}
     */
    protected function hasAttributes(): array
    {
        return \array_merge(parent::hasAttributes(), ['inclusive_attribute']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getRuleString(): string
    {
        return 'requiredWith:inclusive_attribute';
    }
}
