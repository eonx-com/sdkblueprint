<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Parsers;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidBaseUrlException;

interface RequestParserInterface
{
    /**
     * Get request parameters for the HTTP client.
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Get URL for the HTTP client.
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Set base url.
     *
     * @param string $baseUrl
     *
     * @return RequestParserInterface
     *
     * @throws InvalidBaseUrlException If base url is invalid
     */
    public function setBaseUrl(string $baseUrl): self;
}
