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
    public function expectObject(): ?string;

    /**
     * Specify the requst uri.
     *
     * @return array
     */
    public function getUris(): array;

    /**
     * Add options along with sending the request. For example, adding api key in the header.
     *
     * @return null|mixed[]
     */
    public function getOptions(): array;
}
