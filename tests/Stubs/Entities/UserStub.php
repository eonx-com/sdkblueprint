<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Annotations\Repository;
use LoyaltyCorp\SdkBlueprint\Sdk\Entity;

/**
 * @Repository(repositoryClass="Tests\LoyaltyCorp\SdkBlueprint\Stubs\Repositories\UserRepositoryStub")
 */
class UserStub extends Entity
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @inheritdoc
     */
    public function getUris(): array
    {
        return [
            self::GET => 'http://payments.eoneopay.box/tokens/' . $this->__get('id'),
            self::LIST => 'http://payments.eoneopay.box/tokens'
        ];
    }
}
