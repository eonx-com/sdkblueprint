<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;

class EmptyAttributeObjectStub extends DataTransferObject
{
    /**
     * {@inheritdoc}
     */
    protected function hasAttributes(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function hasValidationRules(): array
    {
        return [];
    }
}
