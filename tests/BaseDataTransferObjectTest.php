<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidMethodCallException;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject
 */
class BaseDataTransferObjectTest extends TestCase
{
    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject
     */
    private $dto;

    /**
     * Instantiate attribute.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->dto = new BaseDataTransferObject();
    }

    /**
     * Test the __call method.
     *
     * @return void
     */
    public function testCallMagicMethod(): void
    {
        $this->expectException(InvalidMethodCallException::class);

        $user = new User(['name' => 'Julian']);
        self::assertSame('Julian', $user->getName());
        $user->setName('Sam');
        self::assertSame('Sam', $user->getName());

        /** @noinspection PhpUndefinedMethodInspection method call handled by magic call*/
        self::assertTrue($user->hasName('Name'));

        /** @noinspection PhpUndefinedMethodInspection method call handled by magic call*/
        self::assertTrue($user->isName('Name'));

        /** @noinspection PhpUndefinedMethodInspection test itself is for undefined method*/
        $user->unknownMethod();
    }

    /**
     * Test __isset method.
     *
     * @return void
     */
    public function testIssetMagicMethod(): void
    {
        /** @noinspection PhpUndefinedFieldInspection test itself is for undefined field*/
        self::assertFalse(isset($this->dto->unknownProperty));
    }

    /**
     * Test has method.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testHas(): void
    {
        $method = $this->getMethodAsPublic(BaseDataTransferObject::class, 'has');

        self::assertFalse($method->invokeArgs($this->dto, ['unknownProperty']));
    }
}
