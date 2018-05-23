<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LessThanTest extends ValidationTestCase
{
    /**
     * Test 'lessThan' validation
     *
     * @return void
     */
    public function testLessThanValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 1,
            'invalid' => 5
        ];

        // Run tests
        $this->runValidationTests('lessThan:5');
    }
}
