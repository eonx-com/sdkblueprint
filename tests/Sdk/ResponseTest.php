<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Response
 */
class ResponseTest extends TestCase
{
    /**
     * Test response object successfully.
     *
     * @return void
     */
    public function testResponse(): void
    {
        $response = new Response(['id' => '1'], 200, ['key' => 'value'], 'content');

        self::assertSame('content', $response->getContent());
        self::assertSame(200, $response->getStatusCode());
        self::assertTrue($response->isSuccessful());
        self::assertSame(['key' => 'value'], $response->getHeaders());
        self::assertSame('value', $response->getHeader('key'));
    }
}
