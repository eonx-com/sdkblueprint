<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LengthTest extends ValidationTestCase
{
    /**
     * Test 'length' validation
     *
     * @return void
     */
    public function testLengthValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => '123456789',
            'invalid' => '123'
        ];

        // Run tests
        $this->runValidationTests('length:9');
    }
}
