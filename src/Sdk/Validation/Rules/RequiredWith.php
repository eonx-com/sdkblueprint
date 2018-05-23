<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class RequiredWith extends Rule
{
    /**
     * 'requiredWith' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If this attribute has a value, validation passes
        if (\is_array($this->parameters) === false || $this->hasValue()) {
            return;
        }

        // If one of the parameters exist with a value, fail
        foreach ($this->parameters as $attribute) {
            if ($this->getValue($attribute)) {
                // Validation fails
                $condition = \count($this->parameters) === 1 ?
                    \implode(', ', $this->parameters) . ' is' :
                    'one of [' . \implode(', ', $this->parameters) . '] are';
                $this->error = $this->attribute . ' is required if ' . $condition . ' not empty';
            }
        }
    }
}
