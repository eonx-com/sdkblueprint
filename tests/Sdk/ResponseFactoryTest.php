<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class ResponseFactoryTest extends TestCase
{
    /**
     * @var ResponseFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();

        $this->factory = new ResponseFactory();
    }

    public function testCreateErrorResponse(): void
    {
        $request = $this->createMockPsrRequest();
        $requestException = new RequestException('error message', $request);

        $expect = new Response(0, null, '0', 'error message');
        self::assertEquals($expect, $this->factory->createErrorResponse($requestException));

        //test exception with psr response
        $requestException = new RequestException(
            'error message',
            $request,
            $this->createMockPsrResponse('{"message":"error occurs"}', 500)
        );

        $expect = new Response(500, ['message' => 'error occurs'], '500', 'error occurs');
        self::assertEquals($expect, $this->factory->createErrorResponse($requestException));
    }

    public function testCreateSuccessfulResponse(): void
    {
        //test response is not valid json
        $expect = new Response(200, ['raw' => '"raw":"data"']);
        self::assertEquals($expect, $this->factory->createSuccessfulResponse(
            $this->createMockPsrResponse(
            '"raw":"data"',
            200
        )));

        //test non-raw content.
        $expect = new Response(200, ['data' => ['user_id' => '1']]);
        self::assertEquals($expect, $this->factory->createSuccessfulResponse(
            $this->createMockPsrResponse(
                '{"data":{"user_id":"1"}}',
                200
            )));
    }

    private function createMockPsrRequest(): RequestInterface
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection returned mock object has the same type as expected*/
        return $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function createMockPsrResponse(?string $content = null, int $statusCode): ResponseInterface
    {
        //test response is not valid json
        $streamInterface = $this->getMockBuilder(StreamInterface::class)->getMock();
        $streamInterface->method('getContents')->willReturn($content);
        $psrResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $psrResponse->method('getBody')->willReturn($streamInterface);
        $psrResponse->method('getStatusCode')->willReturn($statusCode);

        /** @noinspection PhpIncompatibleReturnTypeInspection returned mock object has the same type as expected*/
        return $psrResponse;
    }
}
