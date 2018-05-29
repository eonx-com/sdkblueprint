<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class TypeStub extends BaseStub
{
    /**
     * {@inheritdoc}
     */
    protected function getRuleString(): string
    {
        return 'type:string,numeric,digit';
    }
}
