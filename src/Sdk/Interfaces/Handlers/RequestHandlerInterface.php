<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;

interface RequestHandlerInterface extends RequestAwareInterface
{
    /**
     * Execute request and respond.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $action Request action
     * @param string|null $apikey Api key
     * @param mixed[]|null $headers Extra headers.
     *
     * @return mixed
     */
    public function executeAndRespond(
        EntityInterface $entity,
        string $action,
        ?string $apikey = null,
        ?array $headers = null
    );
}
