<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string|null getEntityId()
 * @method self setEntityId(string $entityId)
 */
class EntityStub extends Entity
{
    /**
     * @Groups({"create", "delete", "get", "list", "update"})
     *
     * @var string|null
     */
    protected $entityId;

    /**
     * @inheritdoc
     */
    public function uris(): array
    {
        return [
            self::CREATE => '/test',
            self::DELETE => '/test',
            self::GET => '/test',
            self::LIST => '/test',
            self::UPDATE => '/test'
        ];
    }
}
