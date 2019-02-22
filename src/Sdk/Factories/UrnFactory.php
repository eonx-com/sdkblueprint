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
        // validate url
        $validUrl = \filter_var(\sprintf('http://localhost%s', $uri), \FILTER_VALIDATE_URL);

        if ($validUrl === false) {
            // throw invalid uri exception
            throw new InvalidUriException(\sprintf('Provided URI (%s) in entity is invalid.', $uri));
        }

        return $uri;
    }
}
