<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Handlers;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use LoyaltyCorp\SdkBlueprint\Sdk\Entity;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidApiResponseException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriActionException;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\SerializerFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Factories\UrnFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\UserStub;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Handlers\ResponseHandlerStub;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @noinspection EfferentObjectCouplingInspection High coupling for testing only
 *
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Handlers\RequestHandler
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Test case only, high coupling required to fully test request handler
 */
final class RequestHandlerTest extends TestCase
{
    /**
     * Test that post method of request handler will create an entity successfully.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $data = ['entityId' => 'entity-id'];

        $response = $this->getHandler([
            new Response(201, [], \json_encode($data) ?: ''),
        ])->executeAndRespond(new EntityStub($data), RequestAwareInterface::CREATE, 'api-key');

        self::assertInstanceOf(EntityStub::class, $response);
        self::assertSame($data['entityId'], $response->getEntityId());
    }

    /**
     * Get request handler.
     *
     * @param mixed[]|null $responses PSR-7 http responses
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface
     */
    private function getHandler(?array $responses = null): RequestHandlerInterface
    {
        return new RequestHandler(
            new GuzzleClient(['handler' => new MockHandler($responses)]),
            new ResponseHandlerStub(),
            new SerializerFactory(),
            new UrnFactory()
        );
    }

    /**
     * Test that delete an entity will return null.
     *
     * @return void
     */
    public function testDelete(): void
    {
        $response = $this->getHandler([
            new Response(204, [], null),
        ])->executeAndRespond(new EntityStub(['entityId' => 'entity-id']), RequestAwareInterface::DELETE, 'api-key');

        self::assertNull($response);
    }

    /**
     * Test that get method of request handler will get requested entity successfully.
     *
     * @return void
     */
    public function testGet(): void
    {
        $data = [
            'userId' => 'user-id',
            'type' => 'customer',
            'email' => 'customer@email.test',
            'apikeys' => [
                'key-1',
                'key-2',
            ],
        ];

        $entity = $this->getHandler([
            new Response(200, [], \json_encode($data) ?: ''),
        ])->executeAndRespond(new UserStub(['userId' => 'user-id']), RequestAwareInterface::GET, 'api-key');

        $this->performAssertion($data, $entity);
    }

    /**
     * Perform assertion.
     *
     * @param mixed[] $expected Expected data
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     *
     * @return void
     */
    private function performAssertion(array $expected, EntityInterface $entity): void
    {
        self::assertInstanceOf(UserStub::class, $entity);

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\UserStub $entity */
        self::assertSame($expected['userId'], $entity->getUserId());
        self::assertSame($expected['type'], $entity->getType());
        self::assertSame($expected['email'], $entity->getEmail());
    }

    /**
     * Tests that the request handler throws an exception when the request URI action is invalid.
     *
     * @return void
     */
    public function testInvalidActionThrowsException(): void
    {
        $this->expectException(InvalidUriActionException::class);
        $this->expectExceptionMessage(
            'The URI action (update) is invalid, or not supported for the specified resource.'
        );

        $entityClass = new class() extends Entity {
            /**
             * {@inheritdoc}
             */
            public function uris(): array
            {
                return [
                    self::CREATE => '/create',
                ];
            }
        };

        $handler = $this->getHandler();
        $handler->executeAndRespond($entityClass, RequestAwareInterface::UPDATE, 'api-key');
    }

    /**
     * Test that list method of request handler will list exepected number of entities.
     *
     * @return void
     */
    public function testList(): void
    {
        $data = [
            [
                'userId' => 'user-id',
                'type' => 'customer',
                'email' => 'customer@email.test',
            ],
        ];

        $entities = $this->getHandler([
            new Response(200, [], \json_encode($data) ?: ''),
        ])->executeAndRespond(new UserStub(['userId' => 'user-id']), RequestAwareInterface::LIST, 'api-key');

        self::assertCount(1, $entities);
        $this->performAssertion($data[0], $entities[0]);
    }

    /**
     * Test that request will throw InvalidApiResponseException.
     *
     * @return void
     */
    public function testRequestThrowsInvalidResponseApiException(): void
    {
        $this->expectException(InvalidApiResponseException::class);

        $this->getHandler([
            new ClientException('Internal server error', new Request('GET', 'test')),
        ])->executeAndRespond(new UserStub(['userId' => 'user-id']), RequestAwareInterface::LIST, 'api-key');
    }

    /**
     * Test that put method of request handler will update an entity.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $data = [
            'userId' => 'user-id',
            'type' => 'customer',
            'email' => 'updated@email.test',
        ];

        $entity = $this->getHandler([
            new Response(200, [], \json_encode($data) ?: ''),
        ])->executeAndRespond(new UserStub(\array_merge($data, [
            'email' => 'customer@email.tesjust flot',
        ])), RequestAwareInterface::UPDATE, 'api-key');

        $this->performAssertion($data, $entity);
    }
}
