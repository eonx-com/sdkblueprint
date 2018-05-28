<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\GreaterThanStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class GreaterThanTest extends ValidationTestCase
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be greater than 20';
        $this->invalidValue = '20';
        $this->objectStubClass = GreaterThanStub::class;
        $this->validValue = '21';
    }
}
