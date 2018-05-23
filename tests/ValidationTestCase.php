<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren) All rules extend this class
 */
class ValidationTestCase extends TestCase
{
    /**
     * Test data
     *
     * @var mixed[]
     */
    protected $data;

    /**
     * Run a test against a validation rule
     *
     * @param string $rule The rule to test against
     *
     * @return void
     */
    public function runValidationTests(string $rule): void
    {
        $validator = new Validator();

        // Test valid value
        self::assertTrue($validator->validate(['value' => $this->data['valid']], ['value' => $rule]));

        // Test invalid value
        self::assertFalse($validator->validate(['value' => $this->data['invalid']], ['value' => $rule]));
        self::assertCount(1, $validator->getErrors());
    }
}
