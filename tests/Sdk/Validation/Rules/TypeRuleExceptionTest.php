<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\TypeExceptionStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class TypeRuleExceptionTest extends ValidationTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->objectStubClass = TypeExceptionStub::class;
        $this->errorMessage = 'type parameter is missing, please specify';
    }

    /**
     * {@inheritdoc}
     */
    public function testRule(): void
    {
        $dto = new $this->objectStubClass([self::ATTRIBUTE => $this->invalidValue]);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame($this->errorMessage, $errors[self::ATTRIBUTE][0]);
    }
}
