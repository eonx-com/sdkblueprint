<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface ResponseInterface
{
    /**
     * Get code.
     *
     * @return null|string
     */
    public function getCode(): ?string;

    /**
     * Get response body.
     *
     * @return mixed[]
     */
    public function getContent(): ?array;

    /**
     * Get response message.
     *
     * @return null|string
     */
    public function getMessage(): ?string;

    /**
     * Get response status code.
     *
     * @return null|int
     */
    public function getStatusCode(): ?int;
}
