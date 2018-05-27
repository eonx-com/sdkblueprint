<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class RegexStub extends BaseStub
{
    protected function getRuleString(): string
    {
        return 'regex:/^[\d]{4,}$/';
    }
}
