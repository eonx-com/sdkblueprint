<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\TypeStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class TypeTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be type of digit, string given';
        $this->invalidValue = 'sdfdf';
        $this->objectStubClass = TypeStub::class;
        $this->validValue = '1234';
    }
}
