<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class GreaterThanOrEqualToTest extends ValidationTestCase
{
    /**
     * Test 'greaterThanOrEqualTo' validation
     *
     * @return void
     */
    public function testGreaterThanOrEqualToValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 1,
            'invalid' => 0
        ];

        // Run tests
        $this->runValidationTests('greaterThanOrEqualTo:1');
    }
}
