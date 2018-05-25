<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\EmailRuleStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class EmailTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be a valid email address';
        $this->invalidValue = 'test';
        $this->objectStubClass = EmailRuleStub::class;
        $this->validValue = 'test@test.com';
    }
}
