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
            new Response(200, [], \json_encode(['key' => 'value']))
        );

        self::assertSame('value', $response->get('key'));
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
        $response = (new ResponseHandler())->handleRequestException(
            new RequestException(
                'Test request exception',
                new Request('GET', 'test'),
                new Response(400, [], \json_encode(['message' => 'Test request exception message']) ?: '')
            )
        );

        self::assertSame('Test request exception message', $response->get('message'));
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
    }

    /**
     * Test handle request exception returns expected response.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function testHandleUnknownException(): void
    {
        $response = (new ResponseHandler())->handleRequestException(
            new \Exception('Test unknown exception')
        );

        self::assertSame('Test unknown exception', $response->get('exception'));
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
    }
}
