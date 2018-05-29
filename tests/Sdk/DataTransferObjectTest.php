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
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\ArrayRulesStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\AssemblableObjectObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\DataTransferObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\EmptyAttributeObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\InvalidRuleStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\RuleWithoutAttributeStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\TransactionDtoStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods) they are all necessary public methods
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) they are all required dependencies.
 */
class DataTransferObjectTest extends TestCase
{
    /**
     * Data transfer object.
     *
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\DataTransferObjectStub $dto
     */
    private $dto;

    /**
     * The validator instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator $validator
     */
    private $validator;

    /**
     * Instantiate attributes.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
    public function setUp(): void
    {
        parent::setUp();
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->dto = new DataTransferObjectStub();

        $this->validator = new Validator();
    }

    /**
     * Test getters and setters.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
    public function testSuccessfulGetterAndSetter(): void
    {
        $this->dto->setNumber('123');
        self::assertSame('123', $this->dto->getNumber());

        /** @noinspection PhpUnhandledExceptionInspection */
        $transactionDto = new TransactionDtoStub(['dto' => $this->dto]);

        self::assertInstanceOf(DataTransferObjectStub::class, $transactionDto->getDto());
    }

    /**
     * Test fill data.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
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

    /**
     * Test embedded data.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
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

    /**
     * Make sure all attributes are set.
     *
     * @return void
     */
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

    /**
     * Test to array.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
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

    /**
     * Test invalid magic method.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
    public function testInvalidMethod(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $dto = new DataTransferObjectStub();
        $this->expectException(UndefinedMethodException::class);

        /** @noinspection PhpUndefinedMethodInspection expected method.*/
        $dto->getUndefineMethod();
    }

    /**
     * Test invalid rule.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testInvalidRule(): void
    {
        $dto = new InvalidRuleStub();
        $this->expectException(UndefinedValidationRuleException::class);
        $this->validator->validate($dto);
    }

    /**
     * Make sure passed attributes are fillable.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \ReflectionException
     */
    public function testFillableFromArray(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $method = $this->getMethodAsPublic(DataTransferObject::class, 'fillableFromArray');

        $this->expectException(EmptyAttributesException::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $method->invokeArgs(new EmptyAttributeObjectStub(), [[]]);
    }

    /**
     * Test object validation.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
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

    /**
     * Test invalid rules.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testInvalidRules(): void
    {
        $dto = new RuleWithoutAttributeStub(['attribute' => 'fdsfd']);

        $this->expectException(InvalidRulesException::class);
        $this->validator->validate($dto);
    }

    /**
     * Test array rules.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testArrayRules(): void
    {
        $dto = new ArrayRulesStub(['attribute' => 'string']);

        $expect = ['attribute' => ['attribute must be a numeric']];
        self::assertSame($expect, $this->validator->validate($dto));

        $dto = new ArrayRulesStub(['attribute' => null]);

        $expect = ['attribute' => ['attribute is required']];
        self::assertSame($expect, $this->validator->validate($dto));
    }

    /**
     * Make sure the numbers of parameter passed correct.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \ReflectionException
     */
    public function testValidateParametersNumber(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $method = $this->getMethodAsPublic(DataTransferObject::class, 'validateParametersNumber');

        $this->expectException(InvalidArgumentException::class);
        /** @noinspection PhpUnhandledExceptionInspection */
        $method->invokeArgs(new DataTransferObjectStub(), [1, []]);
    }
}
