<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\LessThanStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LessThanTest extends ValidationTestCase
{
    /**
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testLessThanValidation(): void
    {
        $dto = new LessThanStub(['number' => 20]);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame('number must be less than 20', $errors['number'][0]);

        $dto = new LessThanStub(['age' => 19]);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
