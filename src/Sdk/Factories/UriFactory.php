<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\UriFactoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Uri;

final class UriFactory implements UriFactoryInterface
{
    /**
     * @inheritdoc
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException
     */
    public function create(string $uri): Uri
    {
        // validate uri
        $filteredUri = \filter_var($uri, \FILTER_VALIDATE_URL);

        if ($filteredUri === false) {
            // throw invalid uri exception
            throw new InvalidUriException(\sprintf('Invalid uri %s', $uri));
        }

        return new Uri(
            \parse_url($filteredUri, \PHP_URL_HOST),
            \parse_url($filteredUri, \PHP_URL_PATH),
            \parse_url($filteredUri, \PHP_URL_PORT),
            \parse_url($filteredUri, \PHP_URL_SCHEME)
        );
    }
}
