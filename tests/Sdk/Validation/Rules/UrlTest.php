<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class UrlTest extends ValidationTestCase
{
    /**
     * Test 'url' validation
     *
     * @return void
     */
    public function testUrlValidation(): void
    {
        // Test data
        $this->data = [
            'valid' => 'http://localhost',
            'invalid' => 'localhost'
        ];

        // Run tests
        $this->runValidationTests('url');
    }
}
