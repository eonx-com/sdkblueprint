<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @SuppressWarnings("PMD.StaticAccess") static access is required for annotation loader.
 * @SuppressWarnings("PMD.CouplingBetweenObjects") we need those object to achieve the functionality we want.
 * @SuppressWarnings("PMD.LongVariable") variable names need to be descriptive.
 */
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

        $discriminator = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);

        $refectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();

        $propertyInfoExtractor = new PropertyInfoExtractor(
            [$refectionExtractor],
            [$refectionExtractor, $phpDocExtractor]
        );

        $normalizer = new ObjectNormalizer(
            $classMetadataFactory,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            $propertyInfoExtractor,
            $discriminator
        );

        return new Serializer([$normalizer, new ArrayDenormalizer()], [new JsonEncoder()]);
    }
}
