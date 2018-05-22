<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface SdkResponseInterface
{
    /**
     * Get code.
     *
     * @return null|string
     */
    public function getCode(): ?string;

    /**
     * Get response message.
     *
     * @return null|string
     */
    public function getMessage(): ?string;

    /**
     * Get response status code.
     *
     * @return int|null
     */
    public function getStatusCode(): ?int;

    /**
     * Get response.
     *
     * @return null|ResponseInterface
     */
    public function getResponse(): ?ResponseInterface;

    /**
     * Return whether response is successful or not.
     *
     * @return bool
     */
    public function isSuccessful(): bool;
}
