<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;

class ArrayRulesStub extends DataTransferObject
{
    /**
     * {@inheritdoc}
     */
    protected function hasAttributes(): array
    {
        return ['attribute'];
    }

    /**
     * {@inheritdoc}
     */
    public function hasValidationRules(): array
    {
        return ['attribute' => ['required', 'numeric']];
    }
}
