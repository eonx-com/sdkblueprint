<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class EnumRuleStub extends BaseStub
{
    /**
     * {@inheritdoc}
     */
    protected function getRuleString(): string
    {
        return 'enum:John,Black,Nate';
    }
}
