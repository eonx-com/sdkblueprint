<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestInterface
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
    public function getUri(): string;

    /**
     * Get request.
     *
     * @return mixed[]
     */
    public function getOptions(): array;
}
