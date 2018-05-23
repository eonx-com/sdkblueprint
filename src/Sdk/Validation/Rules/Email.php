<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Email extends Rule
{
    /**
     * 'email' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If attribute isn't a valid email, validation fails
        if ($this->hasValue() && \filter_var($this->getValue(), \FILTER_VALIDATE_EMAIL) === false) {
            $this->error = $this->attribute . ' must be a valid email address';
        }
    }
}
