<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\MinLengthStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class MinLengthTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be at least 3 characters long';
        $this->invalidValue = '12';
        $this->objectStubClass = MinLengthStub::class;
        $this->validValue = '123';
    }
}
