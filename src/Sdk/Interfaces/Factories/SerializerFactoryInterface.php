<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories;

use Symfony\Component\Serializer\Serializer;

interface SerializerFactoryInterface
{
    /**
     * Factory method to create Symfony serializer.
     *
     * @return \Symfony\Component\Serializer\Serializer
     */
    public function create(): Serializer;
}
