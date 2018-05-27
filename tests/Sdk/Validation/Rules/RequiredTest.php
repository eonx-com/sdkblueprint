<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\RequiredStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RequiredTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute is required';
        $this->invalidValue = '';
        $this->objectStubClass = RequiredStub::class;
        $this->validValue = 123456789;
    }
}
