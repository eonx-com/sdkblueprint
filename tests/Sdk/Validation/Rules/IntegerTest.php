<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\IntegerStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class IntegerTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be greater than 20';
        $this->invalidValue = '20';
        $this->objectStubClass = GreaterThanStub::class;
        $this->validValue = '21';
    }

    /**
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testIntegerValidation(): void
    {
        $dto = new IntegerStub(['score' => 'Julian']);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame('score must be an integer', $errors['score'][0]);

        $dto = new IntegerStub(['score' => 100]);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
