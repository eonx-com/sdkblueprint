<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\MaxLengthStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class MaxLengthTest extends ValidationTestCase
{
    public function testMaxLengthValidation(): void
    {
        $dto = new MaxLengthStub(['max' => '1234']);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame('max must be no more than 3 characters long', $errors['max'][0]);

        $dto = new MaxLengthStub(['max' => '123']);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
