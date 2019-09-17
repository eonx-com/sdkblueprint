<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Managers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkManagerInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities\EntityStub;

/**
 * @coversNothing
 */
final class SdkManagerStub implements SdkManagerInterface
{
    /**
     * Entity.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    private $entity;

    /**
     * Construct api manager stub.
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
    public function execute(EntityInterface $entity, string $action, ?string $apikey = null)
    {
        if (\mb_strtolower($action) === RequestAwareInterface::LIST) {
            return [$this->entity];
        }

        return $this->entity;
    }
}
