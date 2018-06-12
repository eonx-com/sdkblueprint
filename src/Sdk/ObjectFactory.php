<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedClassException;

class ObjectFactory
{
    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * Instantiate the object.
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedClassException
     */
    public function create(array $data, string $class)
    {
        if (\class_exists($class) === false) {
            throw new UndefinedClassException(\sprintf('class %s is not defined', $class));
        }

        return $this->serializer->denormalize($data, $class);
    }
}
