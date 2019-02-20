<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Factories;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\UrnFactoryInterface;

final class UrnFactory implements UrnFactoryInterface
{
    /**
     * @inheritdoc
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriException
     */
    public function create(string $uri): string
    {
        // validate uri
        $parsedUri = \parse_url($uri);

        if ($parsedUri === false) {
            // throw invalid uri exception
            throw new InvalidUriException(\sprintf('Provided URI (%s) is invalid.', $uri));
        }

        return $parsedUri['path'] ?? '';
    }
}
