<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\EnumRuleStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class EnumTest extends ValidationTestCase
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be one of [John, Black, Nate]';
        $this->invalidValue = 'Julian';
        $this->objectStubClass = EnumRuleStub::class;
        $this->validValue = 'John';
    }
}
