<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class IntegerStub extends BaseStub
{
    protected function getRuleString(): string
    {
        return 'integer';
    }
}