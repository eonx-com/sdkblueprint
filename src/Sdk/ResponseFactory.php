<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponse;

class ResponseFactory
{
    /**
     * Create an error response from the request exception.
     *
     * @param \GuzzleHttp\Exception\RequestException $exception
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function createErrorResponse(RequestException $exception): ResponseInterface
    {
        $response = $exception->getResponse();

        if (($response instanceof PsrResponse) === false) {
            return new Response(0, null, (string)$exception->getCode(), $exception->getMessage());
        }

        return new Response(
            $response->getStatusCode() ?? 0,
            $response->getBody()->getContents(),
            $contents['code'] ?? (string)$exception->getCode(),
            $contents['message'] ?? $exception->getMessage()
        );
    }

    /**
     * Create a successful response message from a psr response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function createSuccessfulResponse(PsrResponse $response): ResponseInterface
    {
        return new Response($response->getStatusCode(), $response->getBody()->getContents());
    }
}
