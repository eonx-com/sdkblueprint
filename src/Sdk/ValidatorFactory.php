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

        AnnotationRegistry::registerUniqueLoader('class_exists');

        $builder->enableAnnotationMapping();
        return $builder->getValidator();
    }
}
