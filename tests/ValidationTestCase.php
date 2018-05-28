<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren) All rules extend this class
 */
class ValidationTestCase extends TestCase
{
    public const ATTRIBUTE = 'attribute';

    /**
     * The validator instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator $validator
     */
    protected $validator;

    /**
     * The full class namespace.
     *
     * @var string $objectStubClass
     */
    protected $objectStubClass;

    /**
     * The valid data.
     *
     * @var mixed $validValue
     */
    protected $validValue;

    /**
     * The invalid data.
     *
     * @var mixed $invalidValue
     */
    protected $invalidValue;

    /**
     * Expect error message.
     *
     * @var string $errorMessage.
     */
    protected $errorMessage;

    /**
     * Instantiate attributes.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    /**
     * Test validation rules.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testRule(): void
    {
        $dto = new $this->objectStubClass([self::ATTRIBUTE => $this->invalidValue]);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame($this->errorMessage, $errors[self::ATTRIBUTE][0]);

        $dto = new $this->objectStubClass([self::ATTRIBUTE => $this->validValue]);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
