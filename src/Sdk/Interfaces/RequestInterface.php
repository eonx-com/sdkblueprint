<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestInterface
{
    /**
     * Specify the expected object so that the response can populate it.
     *
     * @return null|string
     */
    public function expectObject(): ?string;

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


    public function getValidationGroups(): array;
}
