<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Parsers;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EndpointValidationFailedException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidBaseUrlException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestParserInterface;

class JsonRequestParser implements RequestParserInterface
{
    /** @var string */
    protected $baseUrl = 'http://localhost';

    /** @var string */
    private $method;

    /**
     * Get request parameters for the HTTP client.
     *
     * @return array
     */
    public function getParameters(): array
    {
        // Return empty array if using DELETE or GET as they can't contain request body
        if (\in_array(\mb_strtolower($this->getMethod()), ['delete', 'get'], true)) {
            return [];
        }

        return ['json' => $this->getEndpoint() === null ? [] : $this->getEndpoint()->toArray()];
    }

    /**
     * Get URL for the HTTP client.
     *
     * @return string
     *
     * @throws EndpointValidationFailedException
     */
    public function getUrl(): string
    {
        if (null === $this->getEndpoint() || null === $this->getMethod()) {
            throw new EndpointValidationFailedException('Request failed: the endpoint hasn\'t been set');
        }

        $url = \sprintf(
            '%s/v%s/%s',
            \trim($this->baseUrl, '/'),
            $this->getEndpoint()->getEndpointVersionFromMethod($this->getMethod()),
            $this->getEndpoint()->getEndpointFromMethod($this->getMethod())
        );

        // Build query string if using DELETE or GET as they can't contain request body
        if (\in_array(\mb_strtolower($this->getMethod()), ['delete', 'get'], true)) {
            // Add repository as a query string
            $url = \sprintf('%s?%s', $url, $this->getEndpoint()->getQueryString());
        }

        return $url;
    }

    /**
     * Set base url.
     *
     * @param string $baseUrl
     *
     * @return RequestParserInterface
     *
     * @throws InvalidBaseUrlException If base url is invalid
     */
    public function setBaseUrl(string $baseUrl): RequestParserInterface
    {
        // If url is invalid, throw exception
        if (!\filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidBaseUrlException("Unable to set base url to '$baseUrl' as it's invalid");
        }

        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Set method.
     *
     * @param string $method
     *
     * @return RequestParserInterface
     */
    public function setMethod(string $method): RequestParserInterface
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method.
     *
     * @return string|null
     */
    protected function getMethod(): ?string
    {
        return $this->method;
    }
}
