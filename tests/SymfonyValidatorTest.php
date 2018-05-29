<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use Symfony\Component\Validator\Validation;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\SFDataTransferObjectStub;

class SymfonyValidatorTest extends TestCase
{
    public function testValidation(): void
    {
        $validator = Validation::createValidatorBuilder()->addMethodMapping('loadValidatorMetadata')->getValidator();

        $object = new SFDataTransferObjectStub('fdsfds');

        var_dump($validator->validate($object));
    }
}
