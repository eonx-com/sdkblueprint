<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableInterface;

/**
 * @method DataTransferObjectStub getDto()
 * @method self setDto(DataTransferObjectStub $dto)
 */
class AssemblableObjectStub extends DataTransferObject implements AssemblableInterface
{
    protected function getFillable(): array
    {
        return ['dto'];
    }

    protected function getValidationRules(): array
    {
        return [];
    }

    public function embed(): array
    {
        return ['dto' => DataTransferObjectStub::class];
    }
}
