<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RegexTest extends ValidationTestCase
{
    /**
     * Test 'regex' validation
     *
     * @return void
     */
    public function testRegexValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 123456789, // Pass integer to test casting feature
            'invalid' => '123'
        ];

        // Run tests
        $this->runValidationTests('regex:/^[\d]{4,}$/');
    }
}
