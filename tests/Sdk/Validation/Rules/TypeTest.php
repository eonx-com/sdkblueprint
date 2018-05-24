<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class TypeTest extends ValidationTestCase
{
    /**
     * Test when type validation passed.
     *
     * @return void
     */
    public function testTypeValidationPassed(): void
    {
        $validator = new Validator();

        $rules = ['value' => 'type:string'];
        self::assertTrue($validator->validate(['value' => 'string'], $rules));

        $rules = ['value' => 'type:integer'];
        self::assertTrue($validator->validate(['value' => 123], $rules));

        $rules = ['value' => 'type:bool'];
        self::assertTrue($validator->validate(['value' => true], $rules));

        $rules = ['value' => 'type:array'];
        self::assertTrue($validator->validate(['value' => ['a' => 1, 'b' => 2]], $rules));

        $rules = ['value' => 'type:alnum'];
        self::assertTrue($validator->validate(['value' => 'alphanumeric123'], $rules));

        $rules = ['value' => 'type:alpha'];
        self::assertTrue($validator->validate(['value' => 'alpha'], $rules));

        $rules = ['value' => 'type:string|type:numeric'];
        self::assertTrue($validator->validate(['value' => '123'], $rules));
    }

    /**
     * Test when type validation failed.
     *
     * @return void
     */
    public function testTypeValidationFailed(): void
    {
        $validator = new Validator();

        $rules = ['value' => 'type:string'];
        self::assertFalse($validator->validate(['value' => 123], $rules));
        self::assertEquals(['value' => ['attribute must be type of string, integer given']], $validator->getErrors());

        $rules = ['value' => 'type:integer'];
        self::assertFalse($validator->validate(['value' => 'string'], $rules));
        self::assertEquals(['value' => ['attribute must be type of integer, string given']], $validator->getErrors());

        $rules = ['value' => 'type:bool'];
        self::assertFalse($validator->validate(['value' => 'string'], $rules));
        self::assertEquals(['value' => ['attribute must be type of bool, string given']], $validator->getErrors());

        $rules = ['value' => 'type:array'];
        self::assertFalse($validator->validate(['value' => 123], $rules));
        self::assertEquals(['value' => ['attribute must be type of array, integer given']], $validator->getErrors());

        $rules = ['value' => 'type:alnum'];
        self::assertFalse($validator->validate(['value' => 123], $rules));
        self::assertEquals(['value' => ['attribute must be type of alnum, integer given']], $validator->getErrors());

        $rules = ['value' => 'type:alpha'];
        self::assertFalse($validator->validate(['value' => 123], $rules));
        self::assertEquals(['value' => ['attribute must be type of alpha, integer given']], $validator->getErrors());

        //test when type parameter is missing.
        $rules = ['value' => 'type:'];
        self::assertFalse($validator->validate(['value' => 123], $rules));
        self::assertEquals(['value' => ['type parameter is missing, please specify']], $validator->getErrors());

        //multiple type validation
        $rules = ['value' => 'type:string,numeric'];
        self::assertFalse($validator->validate(['value' => 123], $rules));
        self::assertEquals(['value' => ['attribute must be type of string, integer given']], $validator->getErrors());
    }
}
