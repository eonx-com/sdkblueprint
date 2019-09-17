<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method mixed[]|null getApikeys()
 * @method string|null getEmail()
 * @method string|null getType()
 * @method string|null getUserId()
 * @method self setEmail(string $email)
 * @method self setType(string $type)
 * @method self setUserId(string $userId)
 */
final class UserStub extends Entity
{
    /**
     * @Groups({"create", "delete", "get", "list", "update"})
     *
     * @var mixed[]|null
     */
    protected $apikeys;

    /**
     * @Groups({"create", "delete", "get", "list", "update"})
     *
     * @var string|null
     */
    protected $email;

    /**
     * @Groups({"create", "delete", "get", "list", "update"})
     *
     * @var string|null
     */
    protected $type;

    /**
     * @Groups({"create", "delete", "get", "list", "update"})
     *
     * @var string|null
     */
    protected $userId;

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [
            self::CREATE => '/users',
            self::DELETE => '/users',
            self::GET => '/users',
            self::LIST => '/users',
            self::UPDATE => '/users',
        ];
    }
}
