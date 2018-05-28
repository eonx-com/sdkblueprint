<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedMethodException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException;
use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\AssemblableObjectObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\ArrayRulesStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\InvalidRuleStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\RuleWithoutAttributeStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\EmptyAttributeObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\TransactionDtoStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class DataTransferObjectTest extends TestCase
{
    /**
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub
     */
    private $dto;

    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator
     */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->dto = new DataTransferObjectStub();

        $this->validator = new Validator();
    }

    public function testSuccessfulGetterAndSetter(): void
    {
        $this->dto->setNumber('123');
        self::assertSame('123', $this->dto->getNumber());

        /** @noinspection PhpUnhandledExceptionInspection */
        $transactionDto = new TransactionDtoStub(['dto' => $this->dto]);

        self::assertInstanceOf(DataTransferObjectStub::class, $transactionDto->getDto());
    }

    public function testFillData(): void
    {
        $data = [
            'name' => 'John Smith',
            'number' => '4200000000000000'
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        $dto = new DataTransferObjectStub($data);

        self::assertSame('John Smith', $dto->getName());
        self::assertSame('4200000000000000', $dto->getNumber());
    }

    public function testFillEmbedData(): void
    {
        $data = [
            'transaction' => [
                'amount' => '1000',
                'currency' => 'AUD',
                'dto' => [
                    'name' => 'John Smith',
                    'number' => '4200000000000000'
                ]
            ]
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        $dto = new AssemblableObjectObjectStub($data);

        self::assertInstanceOf(DataTransferObjectStub::class, $dto->getTransaction()->getDto());
        self::assertInstanceOf(TransactionDtoStub::class, $dto->getTransaction());
        self::assertSame('John Smith', $dto->getTransaction()->getDto()->getName());
        self::assertSame('4200000000000000', $dto->getTransaction()->getDto()->getNumber());
        self::assertSame('1000', $dto->getTransaction()->getAmount());
        self::assertSame('AUD', $dto->getTransaction()->getCurrency());
    }

    public function testHasAttributes(): void
    {
        self::assertSame(
            [
                'name' => 'required|type:string|minLength:3',
                'number' => 'required|type:string|minLength:4'
            ],
            $this->dto->hasValidationRules()
        );
    }

    public function testToArray(): void
    {
        $expect = [
            'name' => 'John Smith',
            'number' => '4200000000000000'
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        $dto = new DataTransferObjectStub($expect);
        self::assertSame($expect, $dto->toArray());


        $expect = [
            'transaction' => [
                'amount' => '1000',
                'currency' => 'AUD',
                'dto' => [
                    'name' => 'John Smith',
                    'number' => '4200000000000000'
                ]
            ]
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expect, (new AssemblableObjectObjectStub($expect))->toArray());
    }

    public function testInvalidMethod(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $dto = new DataTransferObjectStub();
        $this->expectException(UndefinedMethodException::class);
        /** @noinspection PhpUndefinedMethodInspection this is what we are testing for*/
        $dto->getUndefineMethod();
    }

    public function testInvalidRule(): void
    {
        $dto = new InvalidRuleStub();
        $this->expectException(UndefinedValidationRuleException::class);
        $this->validator->validate($dto);
    }

    public function testFillableFromArray(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $method = $this->getMethodAsPublic(DataTransferObject::class, 'fillableFromArray');

        $this->expectException(EmptyAttributesException::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $method->invokeArgs(new EmptyAttributeObjectStub(), [[]]);
    }

    public function testValidate(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $dto = new DataTransferObjectStub();

        $expect = [
            'name' => ['name is required', 'attribute must be type of string, NULL given'],
            'number' => ['number is required', 'attribute must be type of string, NULL given']
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expect, $this->validator->validate($dto));

        /** @noinspection PhpUnhandledExceptionInspection */
        $transaction = new TransactionDtoStub();

        $expect = [
            'dto' => ['dto is required'],
            'amount' => ['amount is required', 'attribute must be type of string, NULL given'],
            'currency' => ['currency is required', 'attribute must be type of string, NULL given']
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expect, $this->validator->validate($transaction));

        /** @noinspection PhpUnhandledExceptionInspection */
        $transaction = new TransactionDtoStub(['dto' => new DataTransferObjectStub()]);

        $expect = [
            'dto' => [
                'name' => [
                    'name is required',
                    'attribute must be type of string, NULL given'
                ],
                'number' => [
                    'number is required',
                    'attribute must be type of string, NULL given'
                ]
            ],
            'amount' => ['amount is required', 'attribute must be type of string, NULL given'],
            'currency' => ['currency is required', 'attribute must be type of string, NULL given']
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expect, $this->validator->validate($transaction));
    }

    public function testInvalidRules(): void
    {
        $dto = new RuleWithoutAttributeStub(['attribute' => 'fdsfd']);

        $this->expectException(InvalidRulesException::class);
        $this->validator->validate($dto);
    }

    public function testArrayRules(): void
    {
        $dto = new ArrayRulesStub(['attribute' => 'string']);

        $expect = ['attribute' => ['attribute must be a numeric']];
        self::assertSame($expect, $this->validator->validate($dto));

        $dto = new ArrayRulesStub(['attribute' => null]);

        $expect = ['attribute' => ['attribute is required']];
        self::assertSame($expect, $this->validator->validate($dto));
    }

    public function testValidateParametersNumber(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $method = $this->getMethodAsPublic(DataTransferObject::class, 'validateParametersNumber');

        $this->expectException(InvalidArgumentException::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $method->invokeArgs(new DataTransferObjectStub(), [1, []]);
    }
}
