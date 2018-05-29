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

        $contents =  \json_decode($response->getBody()->getContents(), true);

        return new Response(
            $response->getStatusCode() ?? 0,
            $contents,
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
        // Convert response into array and add success
        $responseContent = $response->getBody()->getContents();

        $contents = \json_decode($responseContent, true);

        // If response isn't json, save to data
        if (\json_last_error() !== \JSON_ERROR_NONE) {
            $contents = ['raw' => $responseContent];
        }

        return new Response($response->getStatusCode(), $contents);
    }
}
