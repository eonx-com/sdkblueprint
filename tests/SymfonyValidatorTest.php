<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use Symfony\Component\Validator\Validation;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObject\Gateway;

class SymfonyValidatorTest extends TestCase
{
    public function testValidation(): void
    {
        $validator = Validation::createValidatorBuilder()->addMethodMapping('loadValidatorMetadata')->getValidator();

        $object = new Gateway('');

        $errors = $validator->validate($object, null, ['creation']);

        self::assertCount(1, $errors);

        $errorString = 'Object(Tests\LoyaltyCorp\SdkBlueprint\DataTransferObject\Gateway).service:
    gateway service is required (code c1051bb4-d103-4f74-8988-acbcafc7fdc3)
';
        self::assertSame($errorString, (string)$errors);

        self::assertCount(0, $validator->validate($object, null, ['deletion']));
    }
}
