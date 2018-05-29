<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\NumericStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class NumericTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be a numeric';
        $this->invalidValue = true;
        $this->objectStubClass = NumericStub::class;
        $this->validValue = '123';
    }
}
