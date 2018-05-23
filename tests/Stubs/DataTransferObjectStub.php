<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;

/**
 * @method string getName()
 * @method string getNumber()
 * @method self setName(string $name)
 * @method self setNumber(string $number)
 */
class DataTransferObjectStub extends DataTransferObject
{
    /**
     * {@inheritdoc}
     */
    protected function hasAttributes(): array
    {
        return [
            'name',
            'number'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function hasValidationRules(): array
    {
        return [
            'name' => 'string|required',
            'number' => 'string|required'
        ];
    }
}
