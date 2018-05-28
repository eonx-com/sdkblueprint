<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\IntegerStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class IntegerTest extends ValidationTestCase
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be an integer';
        $this->invalidValue = 'string';
        $this->objectStubClass = IntegerStub::class;
        $this->validValue = 21;
    }
}
