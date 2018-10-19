<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestObjectInterface
{
    /**
     * Specify the expected returned object.
     *
     * @return null|string
     */
    public function expectObject(): ?string;

    /**
     * Don't prefix method with get or set as serializer will output the method name as attributes.
     *
     * Specify the request uri.
     *
     * @return string[]
     */
    public function uris(): array;
}
