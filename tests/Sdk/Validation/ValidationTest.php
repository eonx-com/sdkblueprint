<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class ValidationTest extends TestCase
{
    /**
     * Validation instance
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator
     */
    private $validator;

    /**
     * Set up validation instance
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Set up validation instance
        $this->validator = new Validator();
    }

    /**
     * Test attempting to validate with a rule that doesn't exist
     *
     * @return void
     */
    public function testInvalidRule(): void
    {
        // Validation should fail due to the invalid rule
        self::assertFalse($this->validator->validate([], ['value' => 'invalidRule']));
        self::assertEquals(["Unknown rule 'invalidRule' used for validation"], $this->validator->getErrors());
    }

    /**
     * Test using multiple rules on a repository
     *
     * @return void
     */
    public function testMultipleRuleValidation(): void
    {
        // Set up data
        $data = [
            'first_name' => 'Bob',
            'last_name' => 'Smith'
        ];

        // Set up rules for a successful validation
        $rules = [
            'first_name' => 'required|minLength:1|maxLength:100',
            'last_name' => 'required|minLength:1|maxLength:100'
        ];

        // Assert success
        self::assertTrue($this->validator->validate($data, $rules));

        // Change last name rule so it doesn't meet minlength requirements
        $rules['last_name'] = 'required|minLength:50|maxLength:100';

        // This will throw a validation error since last name isn't at least 50 characters
        self::assertFalse($this->validator->validate($data, $rules));
        $expected = ['last_name' => ['last_name must be at least 50 characters long']];
        self::assertEquals($expected, $this->validator->getErrors());
    }

    /**
     * Test using multiple rules as array on a repository
     *
     * @return void
     */
    public function testRuleAsArray(): void
    {
        // Set up data
        $data = [
            'first_name' => 'Bob',
            'last_name' => 'Smith'
        ];

        // Set up rules for a successful validation
        $rules = [
            'first_name' => ['required', 'minLength' => 1, 'maxLength' => 100],
            'last_name' => ['required', 'minLength' => 1, 'maxLength' => 100]
        ];

        // Assert success
        self::assertTrue($this->validator->validate($data, $rules));

        // Change last name rule so it doesn't meet minlength requirements
        $rules['last_name'] = 'required|minLength:50|maxLength:100';

        // This will throw a validation error since last name isn't at least 50 characters
        self::assertFalse($this->validator->validate($data, $rules));
        $expected = ['last_name' => ['last_name must be at least 50 characters long']];
        self::assertEquals($expected, $this->validator->getErrors());
    }

    /**
     * Test a rule which relies on another attribute
     *
     * @return void
     */
    public function testRuleWithAttributeParameter(): void
    {
        // Set up data
        $data = [
            'first_name' => 'Bob',
            'last_name' => 'Smith'
        ];

        // Set rule to make first name required if last name is set
        $rules = [
            'first_name' => 'requiredWith:last_name'
        ];

        // Test initial validation
        self::assertTrue($this->validator->validate($data, $rules));

        // Test removing both names, since last name isn't set it should still pass validation
        self::assertTrue($this->validator->validate([], $rules));

        // Set just last name which should invoke requirement for having first name set too
        self::assertFalse($this->validator->validate(['last_name' => 'Smith'], $rules));
        $expected = ['first_name' => ['first_name is required if last_name is not empty']];
        self::assertEquals($expected, $this->validator->getErrors());
    }
}
