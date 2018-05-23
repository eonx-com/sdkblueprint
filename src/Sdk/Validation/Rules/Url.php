<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Url extends Rule
{
    /**
     * 'url' rule
     *
     * @return void
     */
    protected function process(): void
    {
        // If attribute isn't a valid url, validation fails
        if ($this->hasValue() && !filter_var($this->getValue(), FILTER_VALIDATE_URL)) {
            $this->error = $this->attribute . ' must be a valid url';
        }
    }
}
