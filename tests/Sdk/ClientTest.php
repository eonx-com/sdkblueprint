<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\InvalidRequestStub;
use GuzzleHttp\Client as GuzzleClient;

class ClientTest extends HttpRequestTestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(null, null);
    }

    public function testInvalidRequestData(): void
    {
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('{"name":["name is required","attribute must be type of string, NULL given"],"number":["number is required","attribute must be type of string, NULL given"]}');
        $this->client->request(new InvalidRequestStub());
    }

    public function testRequestWithException(): void
    {
        $request = $this->createMockPsrRequest();
        $requestException = new RequestException('error message', $request);

        $requestInterface = $this->getMockBuilder(RequestInterface::class)->getMock();
        $requestInterface->method('getMethod')->willThrowException($requestException);
        $requestInterface->method('getOptions')->willReturn([]);
        $requestInterface->method('getUri')->willReturn('');

        $expect = new Response(0, null, '0', 'error message');
        self::assertEquals($expect, $this->client->request($requestInterface));
    }

    public function testSuccessfulResponse(): void
    {
        $client = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client->method('request')->willReturn($this->createMockPsrResponse('{"data":"user"}', 200));

        $requestInterface = $this->getMockBuilder(RequestInterface::class)->getMock();
        $requestInterface->method('getMethod')->willReturn('');
        $requestInterface->method('getOptions')->willReturn([]);
        $requestInterface->method('getUri')->willReturn('');

        $this->client = new Client($client, null);

        $expect = new Response(200, ['data' => 'user']);
        self::assertEquals($expect, $this->client->request($requestInterface));
    }
}
