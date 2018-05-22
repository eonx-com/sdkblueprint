<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use PHPUnit\Framework\TestCase;
use Tests\LoyaltyCorp\SdkBlueprint\Sdk\Stubs\AssemblableObjectStub;
use Tests\LoyaltyCorp\SdkBlueprint\Sdk\Stubs\DataTransferObjectStub;

class DataTransferObjectTest extends TestCase
{
    /**
     * @return void
     */
    public function testSuccessfulGetterAndSetter(): void
    {
        $dto = new DataTransferObjectStub();

        $dto->setNumber('123');
        self::assertSame('123', $dto->getNumber());
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testFillEmbedData(): void
    {
        $data = [
            'dto' => [
                'name' => 'John Smith',
                'number' => '4200000000000000'
            ]
        ];

        $dto = new AssemblableObjectStub($data);

        self::assertInstanceOf(DataTransferObjectStub::class, $dto->getDto());
        self::assertSame('John Smith', $dto->getDto()->getName());
        self::assertSame('4200000000000000', $dto->getDto()->getNumber());
    }
}
