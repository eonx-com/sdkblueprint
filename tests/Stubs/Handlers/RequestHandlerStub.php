<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;

/**
 * @coversNothing
 */
final class RequestHandlerStub implements RequestHandlerInterface
{
    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    private $entity;

    /**
     * Construct request handler stub.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface|null $entity
     */
    public function __construct(?EntityInterface $entity = null)
    {
        $this->entity = $entity ?? new EntityStub();
    }

    /**
     * @inheritdoc
     */
    public function executeAndRespond(EntityInterface $entity, string $action, ?string $apikey = null)
    {
        if (\mb_strtolower($action) === RequestAwareInterface::LIST) {
            return [$this->entity];
        }

        return $this->entity;
    }
}
