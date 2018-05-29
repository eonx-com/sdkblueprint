<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class MinLength extends Rule
{
    /**
     * 'maxLength' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If string is more than the required, validation fails
        if ($this->hasValue() && \mb_strlen($this->getValue()) < (int)$this->parameters) {
            $this->error = $this->attribute . ' must be at least ' . (int)$this->parameters . ' characters long';
        }
    }
}
