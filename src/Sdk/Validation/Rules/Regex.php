<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Regex extends Rule
{
    /**
     * 'required' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If attribute doesn't match pattern, validation fails
        if ($this->hasValue() && !preg_match($this->parameters, (string) $this->getValue())) {
            $this->error = $this->attribute . ' must match regular expression ' . $this->parameters;
        }
    }
}
