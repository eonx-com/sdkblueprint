<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\LessThanStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LessThanTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be less than 20';
        $this->invalidValue = '20';
        $this->objectStubClass = LessThanStub::class;
        $this->validValue = '19';
    }
}
