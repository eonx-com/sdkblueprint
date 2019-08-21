<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories;

use Symfony\Component\Serializer\SerializerInterface;

interface SerializerFactoryInterface
{
    /**
     * Factory method to create Symfony serializer.
     *
     * @return \Symfony\Component\Serializer\SerializerInterface
     */
    public function create(): SerializerInterface;
}
