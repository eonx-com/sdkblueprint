<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\LengthStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LengthTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be exactly 10 characters long';
        $this->invalidValue = '1234';
        $this->objectStubClass = LengthStub::class;
        $this->validValue = '1234567890';
    }
}
