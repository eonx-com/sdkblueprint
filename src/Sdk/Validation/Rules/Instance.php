<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Instance extends Rule
{
    /**
     * 'instance' rule
     *
     * @return void
     */
    protected function process(): void
    {
        if ($this->hasValue() && !$this->getValue() instanceof $this->parameters) {
            $this->error = \sprintf('%s must be instance of %s', $this->attribute, $this->parameters);
        }
    }
}
