<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\EmailRuleStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\InstanceStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class InstanceTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be instance of Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub';
        $this->invalidValue = new EmailRuleStub();
        $this->objectStubClass = InstanceStub::class;
        $this->validValue = new DataTransferObjectStub();
    }
}
