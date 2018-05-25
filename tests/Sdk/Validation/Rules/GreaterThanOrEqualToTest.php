<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\GreaterThanOrEqualToStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class GreaterThanOrEqualToTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be greater than or equal to 20';
        $this->invalidValue = '19';
        $this->objectStubClass = GreaterThanOrEqualToStub::class;
        $this->validValue = '20';
    }
}
