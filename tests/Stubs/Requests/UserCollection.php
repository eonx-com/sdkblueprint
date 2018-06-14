<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;

class UserCollection implements RequestObjectInterface
{
    /**
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User[]
     */
    private $users = [];

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
     * Get user collection.
     *
     * @return \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * Set user collection.
     *
     * @param \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User[] $users
     *
     * @return void
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [
            RequestMethodInterface::LIST => '/users/'
        ];
    }
}
