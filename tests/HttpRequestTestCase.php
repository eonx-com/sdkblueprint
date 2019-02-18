<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class HttpRequestTestCase extends TestCase
{
    /**
     * Create guzzle client mock.
     *
     * @param \Psr\Http\Message\ResponseInterface|\GuzzleHttp\Exception\RequestException $response
     *
     * @return \GuzzleHttp\Client|\PHPUnit\Framework\MockObject\MockObject
     *
     * @throws \ReflectionException
     */
    protected function createGuzzleClientMock($response)
    {
        /** @var \GuzzleHttp\Client|\PHPUnit\Framework\MockObject\MockObject $guzzleClient */
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($response instanceof ResponseInterface) {
            $guzzleClient->method('request')
                ->willReturn($response);
        } elseif ($response instanceof RequestException) {
            $guzzleClient->method('request')
                ->willThrowException($response);
        }

        return $guzzleClient;
    }

    /**
     * Mock the psr request.
     *
     * @return \Psr\Http\Message\RequestInterface|\PHPUnit\Framework\MockObject\MockObject
     *
     * @throws \ReflectionException
     */
    protected function createMockPsrRequest()
    {
        /** @var \Psr\Http\Message\RequestInterface|\PHPUnit\Framework\MockObject\MockObject $request */
        $request = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $request;
    }

    /**
     * Mock the psr response
     *
     * @param null|string $content
     * @param int $statusCode
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|\Psr\Http\Message\ResponseInterface
     *
     * @throws \ReflectionException
     */
    protected function createMockPsrResponse(?string $content = null, ?int $statusCode = null)
    {
        $statusCode = $statusCode ?? 200;

        //test response is not valid json
        $streamInterface = $this->getMockBuilder(StreamInterface::class)->getMock();
        $streamInterface->method('getContents')->willReturn($content);

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Psr\Http\Message\ResponseInterface $psrResponse */
        $psrResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $psrResponse->method('getBody')->willReturn($streamInterface);
        $psrResponse->method('getStatusCode')->willReturn($statusCode);


        return $psrResponse;
    }
}
