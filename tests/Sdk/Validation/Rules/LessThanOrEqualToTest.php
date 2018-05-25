<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\LessThanOrEqualToStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class LessThanOrEqualToTest extends ValidationTestCase
{
    /**
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testLessThanOrEqualToValidation(): void
    {
        $dto = new LessThanOrEqualToStub(['number' => 21]);
        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame('number must be less than or equal to 20', $errors['number'][0]);

        $dto = new LessThanOrEqualToStub(['age' => 20]);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
