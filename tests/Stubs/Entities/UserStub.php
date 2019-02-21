<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Annotations\Repository;
use LoyaltyCorp\SdkBlueprint\Sdk\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @Repository(repositoryClass="Tests\LoyaltyCorp\SdkBlueprint\Stubs\Repositories\UserRepositoryStub")
 *
 * @method mixed[]|null getApikeys()
 * @method string|null getEmail()
 * @method string|null getType()
 * @method string|null getUserId()
 * @method self setEmail(string $email)
 * @method self setType(string $type)
 * @method self setUserId(string $userId)
 */
class UserStub extends Entity
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
     * @inheritdoc
     */
    public function uris(): array
    {
        return [
            self::CREATE => 'http://localhost/users',
            self::DELETE => 'http://localhost/users',
            self::GET => 'http://localhost/users',
            self::LIST => 'http://localhost/users',
            self::UPDATE => 'http://localhost/users'
        ];
    }
}
