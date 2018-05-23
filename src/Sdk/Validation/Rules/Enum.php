<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Enum extends Rule
{
    /**
     * 'enum' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If value isn't within the enum, validation fails
        if ($this->hasValue() &&
            !\in_array(mb_strtolower($this->getValue()), array_map('mb_strtolower', $this->parameters), true)) {
            $this->error = $this->attribute . ' must be one of [' . implode(', ', $this->parameters) . ']';
        }
    }
}
