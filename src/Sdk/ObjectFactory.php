<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;

class ObjectFactory
{
    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * Instantiate the object.
     */
    public function __construct()
    {
        $this->serializer = (new SerializerFactory())->create();
    }

    /**
     * Create object from array data.
     *
     * @param mixed[] $data
     * @param string $class
     *
     * @return mixed returns object of expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException
     */
    public function create(array $data, string $class)
    {
        if (\class_exists($class) === false) {
            throw new RuntimeException(\sprintf('class %s not found', $class));
        }

        return $this->serializer->denormalize($data, $class);
    }
}
