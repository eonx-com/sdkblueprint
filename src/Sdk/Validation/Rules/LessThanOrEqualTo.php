<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class LessThanOrEqualTo extends Rule
{
    /**
     * 'lessThanOrEqualTo' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If the value is greater than required, validation fails
        if ($this->hasValue() && (int)$this->getValue() > (int)$this->parameters) {
            $this->error = $this->attribute . ' must be less than or equal to ' . (int)$this->parameters;
        }
    }
}
