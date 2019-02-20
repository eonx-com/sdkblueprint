<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories;

interface UrnFactoryInterface
{
    /**
     * Create urn to make api request.
     *
     * @param string $uri URI
     *
     * @return string URN
     */
    public function create(string $uri): string;
}
