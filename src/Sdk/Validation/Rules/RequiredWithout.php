<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class RequiredWithout extends Rule
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

        // If one of the parameters exist with a value, validation passes
        foreach ($this->parameters as $attribute) {
            if ($this->getValue($attribute)) {
                return;
            }
        }

        // Validation fails
        $condition = \count($this->parameters) === 1 ?
            \implode(', ', $this->parameters) :
            'One of [' . \implode(', ', $this->parameters) . ']';
        $this->error = $condition . ' is required if ' . $this->attribute . ' is empty';
    }
}
