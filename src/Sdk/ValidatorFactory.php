<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\Validation;

class ValidatorFactory
{
    public function create()
    {
        $builder = Validation::createValidatorBuilder();

        /** @noinspection PhpDeprecationInspection currently this is the best way to register annotation loader*/
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $builder->enableAnnotationMapping();
        return $builder->getValidator();
    }
}
