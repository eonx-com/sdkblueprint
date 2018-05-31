<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    /**
     * Create the serializer.
     *
     * @return \Symfony\Component\Serializer\Serializer
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function create(): Serializer
    {
        /** @noinspection PhpDeprecationInspection currently this is the best way to register annotation loader*/
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer(
            $classMetadataFactory,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            new ReflectionExtractor()
        );

        // Ignore attributes from RequestObject.
        $normalizer->setIgnoredAttributes(['uris']);

        return new Serializer([$normalizer], [new JsonEncoder()]);
    }
}
