<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LessThanOrEqualToTest extends ValidationTestCase
{
    /**
     * Test 'lessThanOrEqualTo' validation
     *
     * @return void
     */
    public function testLessThanOrEqualToValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 1,
            'invalid' => 10
        ];

        // Run tests
        $this->runValidationTests('lessThanOrEqualTo:5');
    }
}
