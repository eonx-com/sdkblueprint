<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use LoyaltyCorp\SdkBlueprint\Sdk\ResponseFactory;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;

class ResponseFactoryTest extends HttpRequestTestCase
{
    /**
     * Response factory instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\ResponseFactory $factory
     */
    private $factory;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new ResponseFactory();
    }

    /**
     * Test create error response.
     *
     * @return void
     */
    public function testCreateErrorResponse(): void
    {
        /** @var \Psr\Http\Message\RequestInterface $request */
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

    /**
     * Test create successful response.
     *
     * @return void
     */
    public function testCreateSuccessfulResponse(): void
    {
        //test response is not valid json
        $expect = new Response(200, ['raw' => '"raw":"data"']);
        /** @noinspection PhpParamsInspection mock object type is expected.*/
        self::assertEquals($expect, $this->factory->createSuccessfulResponse(
            $this->createMockPsrResponse(
                '"raw":"data"',
                200
            )
        ));

        //test non-raw content.
        $expect = new Response(200, ['data' => ['user_id' => '1']]);
        /** @noinspection PhpParamsInspection mock object type is expected.*/
        self::assertEquals($expect, $this->factory->createSuccessfulResponse(
            $this->createMockPsrResponse(
                '{"data":{"user_id":"1"}}',
                200
            )
        ));
    }
}
