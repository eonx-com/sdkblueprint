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
     * @var Validator $validator
     */
    protected $validator;

    protected $objectStubClass;

    protected $validValue;

    protected $invalidValue;

    protected $errorMessage;

    public function setUp()
    {
        parent::setUp();
        $this->validator = new Validator();
    }

    /**
     * @return void
     *
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
