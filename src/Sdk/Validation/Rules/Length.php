<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Length extends Rule
{
    /**
     * 'length' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If string isn't the right length, validation fails
        if ($this->hasValue() && \mb_strlen($this->getValue()) !== (int)$this->parameters) {
            $this->error = $this->attribute . ' must be exactly ' . (int)$this->parameters . ' characters long';
        }
    }
}
