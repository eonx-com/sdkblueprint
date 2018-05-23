<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableObjectInterface;

/**
 * @method DataTransferObjectStub getDto()
 * @method self setDto(DataTransferObjectStub $dto)
 */
class AssemblableObjectObjectStub extends DataTransferObject implements AssemblableObjectInterface
{
    protected function hasAttributes(): array
    {
        return ['dto'];
    }

    protected function hasValidationRules(): array
    {
        return [];
    }

    public function embedObjects(): array
    {
        return ['dto' => DataTransferObjectStub::class];
    }
}
