<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RequiredWithTest extends ValidationTestCase
{
    /**
     * Test 'requiredWith' validation
     *
     * @return void
     */
    public function testRequiredWithValidation(): void
    {
        $validator = new Validator;

        // Set rules
        $rules = ['value' => 'requiredWith:test'];

        // Test value being set
        self::assertTrue($validator->validate(['value' => true], $rules));

        // Test no fields being set
        self::assertTrue($validator->validate([], $rules));

        // Test alternate field being set
        self::assertFalse($validator->validate(['test' => true], $rules));
        self::assertEquals(['value' => ['value is required if test is not empty']], $validator->getErrors());
    }
}
