<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface EntityInterface extends RequestAwareInterface
{
    /**
     * Get uri for this entity.
     *
     * @return mixed[] Api endpoint uris
     */
    public function getUris(): array;
}
