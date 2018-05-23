<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RequiredWithoutTest extends ValidationTestCase
{
    /**
     * Test 'requiredWithout' validation
     *
     * @return void
     */
    public function testRequiredWithoutValidation(): void
    {
        $validator = new Validator;

        // Set rules
        $rules = ['test' => 'requiredWithout:value'];

        // Test value being set
        self::assertTrue($validator->validate(['value' => true], $rules));

        // Test alternate field being set
        self::assertTrue($validator->validate(['test' => true], $rules));

        // Test neither being set
        self::assertFalse($validator->validate([], $rules));
        self::assertEquals(['test' => ['value is required if test is empty']], $validator->getErrors());
    }
}
