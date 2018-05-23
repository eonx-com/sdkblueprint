<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class NumericTest extends ValidationTestCase
{
    /**
     * Test 'numeric' validation
     *
     * @return void
     */
    public function testNumericValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 123.45,
            'invalid' => 'abc'
        ];

        // Run tests
        $this->runValidationTests('numeric');
    }
}
