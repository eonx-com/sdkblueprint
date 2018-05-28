<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class LessThan extends Rule
{
    /**
     * 'lessThan' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If the value is greater than than or equal to required, validation fails
        if ($this->hasValue() && (int)$this->getValue() >= (int)$this->parameters) {
            $this->error = $this->attribute . ' must be less than ' . (int)$this->parameters;
        }
    }
}
