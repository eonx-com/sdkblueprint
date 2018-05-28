<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Exception\RequestException;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;

class ResponseFactoryTest extends HttpRequestTestCase
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
}
