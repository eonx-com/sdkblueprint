<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\AssemblableObjectObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\TransactionDtoStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class DataTransferObjectTest extends TestCase
{
    /**
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObjectStub
     */
    private $dto;

    public function setUp(): void
    {
        parent::setUp();
        $this->dto = new DataTransferObjectStub();
    }

    public function testSuccessfulGetterAndSetter(): void
    {
        $this->dto->setNumber('123');
        self::assertSame('123', $this->dto->getNumber());
    }

    public function testFillData(): void
    {
        $data = [
            'name' => 'John Smith',
            'number' => '4200000000000000'
        ];

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
            'name' => 'string|required',
            'number' => 'string|required'
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

        self::assertSame($expect, (new AssemblableObjectObjectStub($expect))->toArray());
    }
}
