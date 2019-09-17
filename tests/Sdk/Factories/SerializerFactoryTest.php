<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory
 */
final class SerializerFactoryTest extends TestCase
{
    /**
     * Test create serializer instance via factory successfully.
     *
     * @return void
     */
    public function testCreate(): void
    {
        (new SerializerFactory())->create();

        // If factory was instantiated without exception, all good
        $this->addToAssertionCount(1);
    }
}
