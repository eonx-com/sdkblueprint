<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory;
use Symfony\Component\Serializer\Serializer;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory
 */
class SerializerFactoryTest extends TestCase
{
    /**
     * Test create serializer instance via factory successfully.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testCreate(): void
    {
        $serializer = (new SerializerFactory())->create();

        self::assertInstanceOf(Serializer::class, $serializer);
    }
}
