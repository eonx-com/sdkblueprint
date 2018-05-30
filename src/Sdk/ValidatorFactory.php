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

        $loader = require __DIR__.'/../../vendor/autoload.php';
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);

        $builder->enableAnnotationMapping();
        return $builder->getValidator();
    }
}
