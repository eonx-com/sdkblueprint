<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Uri;

interface UriFactoryInterface
{
    /**
     * Create uri to make api request.
     *
     * @param string $uri
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Uri
     */
    public function create(string $uri): Uri;
}
