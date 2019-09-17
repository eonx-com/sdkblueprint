<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

use EoneoPay\Utils\Interfaces\CollectionInterface;

interface ResponseInterface extends CollectionInterface
{
    /**
     * Get response content.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Get response header.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function getHeader(string $key): ?string;

    /**
     * Get response headers.
     *
     * @return mixed[]
     */
    public function getHeaders(): array;

    /**
     * Get response status code.
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Determine if the response is successful or not.
     *
     * @return bool
     */
    public function isSuccessful(): bool;
}
