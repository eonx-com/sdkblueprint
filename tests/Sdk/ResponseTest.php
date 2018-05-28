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

    public function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, ['response' => 'data'], '1', 'success');
    }

    public function testGetStatusCode(): void
    {
        self::assertSame(200, $this->response->getStatusCode());
    }

    public function testGetMessage(): void
    {
        self::assertSame('success', $this->response->getMessage());
    }

    public function testGetCode(): void
    {
        self::assertSame('1', $this->response->getCode());
    }

    public function testGetContent(): void
    {
        self::assertSame(['response' => 'data'], $this->response->getContent());
    }
}
