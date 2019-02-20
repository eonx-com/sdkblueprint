<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Entity;

/**
 * @method string|null getEntityId()
 * @method self setEntityId(string $entityId)
 */
class EntityStub extends Entity
{
    /**
     * @var string|null
     */
    protected $entityId;

    /**
     * @inheritdoc
     */
    public function getUris(): array
    {
        return [];
    }
}
