<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class LengthStub extends BaseStub
{
    protected function getRuleString(): string
    {
        return 'length:10';
    }
}
