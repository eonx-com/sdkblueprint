<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;
use LoyaltyCorp\SdkBlueprint\Sdk\ObjectFactory;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\ObjectFactory
 */
class ObjectFactoryTest extends TestCase
{
    /**
     * Make sure object factory returns expected object.
     *
     * @return  void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException
     */
    public function testCreateSuccessfully(): void
    {
        $data = [
            'month' => '04',
            'year' => '2018'
        ];

        $object = (new ObjectFactory())->create($data, Expiry::class);
        self::assertInstanceOf(Expiry::class, $object);
        self::assertSame('04', $object->getMonth());
        self::assertSame('2018', $object->getYear());
    }

    /**
     * Make sure expected exception is thrown when class not found.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testCreateWhenClassNotFound(): void
    {
        $this->expectException(RuntimeException::class);

        $data = [
            'month' => '04',
            'year' => '2018'
        ];

        (new ObjectFactory())->create($data, 'App\Undefined\Class');
    }
}
