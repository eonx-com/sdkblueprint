<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Required extends Rule
{
    /**
     * 'required' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If attribute has no value, fail
        if (!$this->hasValue()) {
            $this->error = $this->attribute . ' is required';
        }
    }
}
