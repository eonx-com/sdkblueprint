<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Client;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\InvalidRequestStub;

class ClientTest extends HttpRequestTestCase
{
    /**
     * The Sdk http client.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Client $client
     */
    private $client;

    /**
     * Instantiate attributes.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(null, null);
    }

    /**
     * Test invalid request data.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testInvalidRequestData(): void
    {
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('{"name":["name is required","attribute must be type of string, NULL given"],
        "number":["number is required","attribute must be type of string, NULL given"]}');
        $this->client->request(new InvalidRequestStub());
    }

    /**
     * Test request which will cause an exception.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
    public function testRequestWithException(): void
    {
        /** @var \Psr\Http\Message\RequestInterface $request */
        $request = $this->createMockPsrRequest();
        $requestException = new RequestException('error message', $request);

        $requestInterface = $this->getMockBuilder(RequestInterface::class)->getMock();
        $requestInterface->method('getMethod')->willThrowException($requestException);
        $requestInterface->method('getOptions')->willReturn([]);
        $requestInterface->method('getUri')->willReturn('');

        $expect = new Response(0, null, '0', 'error message');
        /** @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface $requestInterface*/
        self::assertEquals($expect, $this->client->request($requestInterface));
    }

    /**
     * Test successful request response.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRulesException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     */
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

        /** @noinspection PhpParamsInspection */
        $this->client = new Client($client, null);

        $expect = new Response(200, ['data' => 'user']);
        /** @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface $requestInterface */
        self::assertEquals($expect, $this->client->request($requestInterface));
    }
}
