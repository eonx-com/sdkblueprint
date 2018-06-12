<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @SuppressWarnings("PMD.StaticAccess") static access is required for annotation loader.
 */
class ValidatorFactory
{
    /**
     * Create the validator object.
     *
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    public function create(): ValidatorInterface
    {
        $builder = Validation::createValidatorBuilder();

        /** @noinspection PhpDeprecationInspection currently this is the best way to register annotation loader*/
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $builder->enableAnnotationMapping();
        return $builder->getValidator();
    }
}
