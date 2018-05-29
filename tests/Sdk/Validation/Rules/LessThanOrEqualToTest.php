<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\LessThanOrEqualToStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LessThanOrEqualToTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be less than or equal to 20';
        $this->invalidValue = '21';
        $this->objectStubClass = LessThanOrEqualToStub::class;
        $this->validValue = '20';
    }
}
