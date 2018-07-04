<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\ValidatorFactory;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\ValidatorFactory
 */
class ValidatorFactoryTest extends TestCase
{
    /**
     * Make sure a validator object created successfully.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $validator = (new ValidatorFactory())->create();

        $errors = $validator->validate(new Expiry(), null, ['create']);

        self::assertCount(2, $errors);
    }
}
