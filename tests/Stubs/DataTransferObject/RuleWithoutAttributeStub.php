<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;

class RuleWithoutAttributeStub extends DataTransferObject
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
        return ['required', 'numeric'];
    }
}
