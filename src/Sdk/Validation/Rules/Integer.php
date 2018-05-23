<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Integer extends Rule
{
    /**
     * 'integer' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If value doesn't only contain numbers it's invalid
        if ($this->hasValue() && preg_replace('/\D/', '', $this->getValue()) !== (string)$this->getValue()) {
            $this->error = $this->attribute . ' must be an integer';
        }
    }
}
