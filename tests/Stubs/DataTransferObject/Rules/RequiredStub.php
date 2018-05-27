<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules;

class RequiredStub extends BaseStub
{
    protected function getRuleString(): string
    {
        return 'required';
    }
}
