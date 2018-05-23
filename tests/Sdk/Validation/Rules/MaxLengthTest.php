<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class MaxLengthTest extends ValidationTestCase
{
    /**
     * Test 'maxLength' validation
     *
     * @return void
     */
    public function testMaxLengthValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => '123',
            'invalid' => '123456789'
        ];

        // Run tests
        $this->runValidationTests('maxLength:3');
    }
}
