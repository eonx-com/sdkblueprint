<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\DataTransferObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\EmailRuleStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\InstanceStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class InstanceTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = \sprintf('attribute must be instance of %s', DataTransferObjectStub::class);
        $this->invalidValue = new EmailRuleStub();
        $this->objectStubClass = InstanceStub::class;
        $this->validValue = new DataTransferObjectStub();
    }
}
