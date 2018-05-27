<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\MaxLengthStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class MaxLengthTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be no more than 3 characters long';
        $this->invalidValue = '1234';
        $this->objectStubClass = MaxLengthStub::class;
        $this->validValue = '123';
    }
}
