<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Annotations\Repository;
use LoyaltyCorp\SdkBlueprint\Sdk\Entity;

/**
 * @Repository(repositoryClass="Tests\LoyaltyCorp\SdkBlueprint\Stubs\Repositories\UserRepositoryStub")
 *
 * @method string|null getType()
 * @method string|null getUserId()
 */
class UserStub extends Entity
{
    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $userId;

    /**
     * @inheritdoc
     */
    public function getUris(): array
    {
        return [];
    }
}
