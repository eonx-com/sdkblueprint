<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Numeric extends Rule
{
    /**
     * 'numeric' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If value isn't numeric it's invalid
        if ($this->hasValue() && \is_numeric($this->getValue()) === false) {
            $this->error = $this->attribute . ' must be a numeric';
        }
    }
}
