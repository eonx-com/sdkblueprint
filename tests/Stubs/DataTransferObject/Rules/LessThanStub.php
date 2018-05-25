<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class LessThanStub extends BaseStub
{
    protected function getRuleString(): string
    {
        return 'lessThan:20';
    }
}
