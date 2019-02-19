<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface UriInterface
{
    /**
     * Return the string representation of this URI.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Retrieve the host component of the URI.
     *
     * @return string The URI host.
     */
    public function getHost(): string;

    /**
     * Retrieve the path component of the URI.
     *
     * @return string The URI path.
     */
    public function getPath(): string;

    /**
     * Retrieve the port component of the URI.
     *
     * @return null|int The URI port.
     */
    public function getPort(): ?int;

    /**
     * Retrieve the scheme component of the URI.
     *
     * @return string The URI scheme.
     */
    public function getScheme(): string;

    /**
     * Return the array representation of this URI.
     *
     * @return mixed[]
     */
    public function toArray(): array;
}
