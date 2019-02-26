<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\UrnFactory;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Factories\UrnFactory
 */
class UrnFactoryTest extends TestCase
{
    /**
     * Test that URN factory will return path from a valid URI.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException
     */
    public function testCreate(): void
    {
        $path = (new UrnFactory())->create('/api/users');

        self::assertSame('/api/users', $path);
    }

    /**
     * Test that URN factory will throw InvalidUriException when an invalid URI is provided.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException
     */
    public function testCreateThrowsInvalidUriException(): void
    {
        $uri = 'https:::::/orders/order-id/transactions/txn-id';

        $this->expectException(InvalidUriException::class);
        $this->expectExceptionMessage(\sprintf('Provided URI (%s) in entity is invalid.', $uri));

        (new UrnFactory())->create($uri);
    }
}
