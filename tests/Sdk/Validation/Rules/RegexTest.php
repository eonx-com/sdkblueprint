<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\RegexStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RegexTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must match regular expression /^[\d]{4,}$/';
        $this->invalidValue = '123';
        $this->objectStubClass = RegexStub::class;
        $this->validValue = 123456789;
    }
}
