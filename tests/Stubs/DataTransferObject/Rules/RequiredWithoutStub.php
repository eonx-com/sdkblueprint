<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class RequiredWithoutStub extends BaseStub
{
    /**
     * {@inheritdoc}
     */
    protected function getRuleString(): string
    {
        return 'requiredWithout:exclusive_attribute';
    }
}
