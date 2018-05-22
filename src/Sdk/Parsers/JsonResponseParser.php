<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Parsers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseParserInterface;
use Psr\Http\Message\ResponseInterface;

class JsonResponseParser implements ResponseParserInterface
{
    /**
     * Parse error response and return data array.
     *
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws \RuntimeException If response contents aren't readable
     */
    public function parseErrorResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Parse response and return data array.
     *
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws \RuntimeException If response contents aren't readable
     */
    public function parseResponse(ResponseInterface $response): array
    {
        // Convert response into array and add success
        $contents = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        // If response isn't json, save to data
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = ['raw' => $contents];
        }

        return $data;
    }
}
