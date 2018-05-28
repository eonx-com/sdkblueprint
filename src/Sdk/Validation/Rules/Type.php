<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule;

class Type extends Rule
{
    /**
     * 'type' rule
     *
     * @return void
     */
    protected function process(): void
    {
        foreach ($this->parameters as $parameter) {
            if (empty($parameter)) {
                $this->error = 'type parameter is missing, please specify';
                return;
            }

            $type = \strtolower($parameter);

            $isFunction = \sprintf('is_%s', $type);
            $ctypeFunction = \sprintf('ctype_%s', $type);

            $value = $this->getValue();
            if (\function_exists($isFunction) && $isFunction($value)) {
                continue;
            }

            if (\function_exists($ctypeFunction) && $ctypeFunction($value)) {
                continue;
            }

            $this->error = \sprintf('attribute must be type of %s, %s given', $type, \gettype($value));
        }
    }
}
