<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestObjectInterface
{
    /**
     * Specify the expected returned object.
     *
     * @return string
     */
    public function expectObject(): string;

    /**
     * Don't prefix method with get or set as serializer will output the method name as attributes.
     *
     * Specify the requst uri.
     *
     * @return array
     */
    public function uris(): array;
}
