<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Handlers;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use LoyaltyCorp\SdkBlueprint\Sdk\Handlers\ResponseHandler;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Handlers\ResponseHandler
 */
class ResponseHandlerTest extends TestCase
{
    /**
     * Test handle returns expected response.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function testHandleJsonResponse(): void
    {
        $response = (new ResponseHandler())->handle(
            new Response(200, [], \json_encode(['key' => 'value']) ?: '')
        );

        self::assertSame('value', $response->get('key'));
        self::assertSame(200, $response->getStatusCode());
    }

    /**
     * Test handle request exception returns expected response.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function testHandleRequestException(): void
    {
        $response = (new ResponseHandler())->handleException(
            new RequestException(
                'Test request exception',
                new Request('GET', 'test'),
                new Response(400, [], \json_encode(['message' => 'Test request exception message']) ?: '')
            )
        );

        self::assertSame('Test request exception message', $response->get('message'));
        self::assertSame(400, $response->getStatusCode());
    }

    /**
     * Test handle request exception with no response returns expected response.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function testHandleRequestExceptionWithNoResponse(): void
    {
        $response = (new ResponseHandler())->handleException(
            new RequestException(
                'Test request exception',
                new Request('GET', 'test')
            )
        );

        self::assertSame('Test request exception', $response->get('exception'));
        self::assertSame(400, $response->getStatusCode());
    }

    /**
     * Test handle text response.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function testHandleTextResponse(): void
    {
        $response = (new ResponseHandler())->handle(
            new Response(200, [], 'Test text')
        );

        self::assertSame('Test text', $response->getContent());
        self::assertSame(200, $response->getStatusCode());
    }

    /**
     * Test handle xml response.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function testHandleXmlResponse(): void
    {
        $content = '<?xml version=\'1.0\'?> <document>Important Doc</document>';

        $response = (new ResponseHandler())->handle(
            new Response(200, [], $content)
        );

        self::assertSame($content, $response->getContent());
        self::assertSame(200, $response->getStatusCode());
    }
}
