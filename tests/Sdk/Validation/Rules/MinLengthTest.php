<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class MinLengthTest extends ValidationTestCase
{
    /**
     * Test 'minLength' validation
     *
     * @return void
     */
    public function testMinLengthValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => '123456789',
            'invalid' => '123'
        ];

        // Run tests
        $this->runValidationTests('minLength:4');
    }
}
