<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\RequiredWithStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class RequiredWithTest extends ValidationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->errorMessage = 'attribute is required if inclusive_attribute is not empty';
        $this->invalidValue = null;
        $this->objectStubClass = RequiredWithStub::class;
        $this->validValue = 'fdf';
    }

    public function testRule(): void
    {
        $dto = new $this->objectStubClass([
            'inclusive_attribute' => 'fdsfds'
        ]);

        $errors = $this->validator->validate($dto);
        self::assertCount(1, $errors);
        self::assertSame($this->errorMessage, $errors[self::ATTRIBUTE][0]);

        $dto = new $this->objectStubClass([self::ATTRIBUTE => $this->validValue, 'inclusive_attribute' => $this->invalidValue]);
        self::assertCount(0, $this->validator->validate($dto));
    }
}
