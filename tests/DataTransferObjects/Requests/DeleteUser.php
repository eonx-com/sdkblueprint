<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\User;

class DeleteUser extends User implements RequestInterface
{
    public function expectObject(): ?string
    {
        return User::class;
    }

    public function getUri(): string
    {
        return 'delete_uri';
    }

    public function getOptions(): array
    {
        return [];
    }

    public function getValidationGroups(): array
    {
        return ['create'];
    }
}
