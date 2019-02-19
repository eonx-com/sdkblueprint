<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Annotations;

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
