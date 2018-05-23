<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class InstanceTest extends ValidationTestCase
{
    /**
     * Test 'instance' validation
     *
     * @return void
     */
    public function testInstanceValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => new DataTransferObjectStub(),
            'invalid' => new \stdClass()
        ];

        // Run tests
        $this->runValidationTests('instance:Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub');
    }
}
