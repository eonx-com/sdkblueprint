<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class IntegerTest extends ValidationTestCase
{
    /**
     * Test 'integer' validation
     *
     * @return void
     */
    public function testIntegerValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 1234567890,
            'invalid' => 123.45
        ];

        // Run tests
        $this->runValidationTests('integer');
    }
}
