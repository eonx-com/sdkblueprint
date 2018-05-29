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

        /** @var \Symfony\Component\Validator\ConstraintViolationInterface $constraint */
        $constraint = $errors[0];
        //test the error message.
        self::assertSame('gateway service is required', $constraint->getMessage());
        //test the property.
        self::assertSame('service', $constraint->getPropertyPath());

        self::assertCount(0, $validator->validate($object, null, ['deletion']));
    }
}
