<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class GreaterThan extends Rule
{
    /**
     * 'greaterThan' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If the value is less than or equal to required, validation fails
        if ($this->hasValue() && (int)$this->getValue() <= (int)$this->parameters) {
            $this->error = $this->attribute . ' must be greater than ' . (int)$this->parameters;
        }
    }
}
