<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;

class UserCollection implements RequestObjectInterface
{
    /**
     * The users collection.
     *
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User[]
     */
    protected $users = [];

    /**
     * Add a user object into the collection.
     *
     * @param \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User $user
     *
     * @return void
     */
    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function expectObject(): string
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [
            RequestMethodAwareInterface::LIST => '/users/'
        ];
    }
}
