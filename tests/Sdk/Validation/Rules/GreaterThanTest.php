<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class GreaterThanTest extends ValidationTestCase
{
    /**
     * Test 'greaterThan' validation
     *
     * @return void
     */
    public function testGreaterThanValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 5,
            'invalid' => 1
        ];

        // Run tests
        $this->runValidationTests('greaterThan:1');
    }
}
