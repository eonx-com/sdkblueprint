<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
class Repository
{
    /**
     * Entity repository class.
     *
     * @var string
     */
    public $repositoryClass;
}
