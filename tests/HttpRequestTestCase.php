<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class HttpRequestTestCase extends TestCase
{
    protected function createMockPsrRequest(): MockObject
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection returned mock object has the same type as expected*/
        return $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createMockPsrResponse(?string $content = null, int $statusCode): MockObject
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
