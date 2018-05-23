<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

abstract class Command extends DataTransferObject
{
    /**
     * Get the HTTP request method.
     *
     * @return string
     */
    abstract public function getMethod(): string;

    /**
     * Get the HTTP request uri.
     *
     * @return string
     */
    abstract public function getEndpoint(): string;

    /**
     * Get options needed for a HTTP request.
     *
     * @return mixed[]
     */
    abstract public function getOptions(): array;
}
