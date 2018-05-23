<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class EmailTest extends ValidationTestCase
{
    /**
     * Test 'email' validation
     *
     * @return void
     */
    public function testEmailValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 'test@test.com',
            'invalid' => 'invalid'
        ];

        // Run tests
        $this->runValidationTests('email');
    }
}
