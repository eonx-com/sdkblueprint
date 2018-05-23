<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class EnumTest extends ValidationTestCase
{
    /**
     * Test 'enum' validation
     *
     * @return void
     */
    public function testEnumValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 'valid',
            'invalid' => 'invalid'
        ];

        // Run tests
        $this->runValidationTests('enum:valid');

        // Ensure case insensitivty
        $this->runValidationTests('enum:VALID');
    }
}
