<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class MaxLengthStub extends BaseStub
{
    protected function getRuleString(): string
    {
        return 'maxLength:3';
    }
}
