<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\LengthStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LengthTest extends ValidationTestCase
{
    /**
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testLengthValidation(): void
    {
        $dto = new LengthStub(['length' => '1234']);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame('length must be exactly 10 characters long', $errors['length'][0]);

        $dto = new LengthStub(['length' => '1234567890']);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
