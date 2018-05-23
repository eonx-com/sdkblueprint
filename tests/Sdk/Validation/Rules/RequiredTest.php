<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RequiredTest extends ValidationTestCase
{
    /**
     * Test 'required' validation
     *
     * @return void
     */
    public function testRequiredValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => '123456789',
            'invalid' => null
        ];

        // Run tests
        $this->runValidationTests('required');
    }
}
