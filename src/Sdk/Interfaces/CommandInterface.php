<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface CommandInterface
{
    /**
     * Get the HTTP request method.
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Get the HTTP request uri.
     *
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * Get options needed for a HTTP request.
     *
     * @return mixed[]
     */
    public function getOptions(): array;

    /**
     * Get request body.
     *
     * @return mixed[]
     */
    public function getParameters(): array;
}
