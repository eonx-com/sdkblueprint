<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface SdkManagerInterface
{
    /**
     * Execute request and respond.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $action Request action i.e. RequestAwareInterface::CREATE, RequestAwareInterface::GET etc.
     * @param string|null $apikey Api key
     *
     * @return mixed
     */
    public function execute(EntityInterface $entity, string $action, ?string $apikey = null);
}
