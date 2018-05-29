<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\RequiredWithoutStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RequiredWithoutTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'exclusive_attribute is required if attribute is empty';
        $this->invalidValue = '';
        $this->objectStubClass = RequiredWithoutStub::class;
        $this->validValue = 'fdf';
    }
}
