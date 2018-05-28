<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class ResponseTest extends TestCase
{
    /**
     * The response instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Response $response
     */
    private $response;

    /**
     * Instantiate the attribute.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, ['response' => 'data'], '1', 'success');
    }

    /**
     * Make sure the status code is what is expected.
     *
     * @return void
     */
    public function testGetStatusCode(): void
    {
        self::assertSame(200, $this->response->getStatusCode());
    }

    /**
     * Make sure the message is what is expected.
     *
     * @return void
     */
    public function testGetMessage(): void
    {
        self::assertSame('success', $this->response->getMessage());
    }

    /**
     * Make sure the code is what is expected.
     *
     * @return void
     */
    public function testGetCode(): void
    {
        self::assertSame('1', $this->response->getCode());
    }

    /**
     * Make sure the content is what is expected.
     *
     * @return void
     */
    public function testGetContent(): void
    {
        self::assertSame(['response' => 'data'], $this->response->getContent());
    }
}
