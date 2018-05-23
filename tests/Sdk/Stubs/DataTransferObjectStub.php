<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;

/**
 * @method string getName()
 * @method string getNumber()
 * @method self setName(string $name)
 * @method self setNumber(string $number)
 */
class DataTransferObjectStub extends DataTransferObject
{
    protected function hasAttributes(): array
    {
        return [
            'name',
            'number'
        ];
    }

    protected function getValidationRules(): array
    {
        return [];
    }
}
