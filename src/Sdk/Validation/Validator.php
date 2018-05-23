<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation;

class Validator
{
    /**
     * Repository validation rules
     *
     * @var mixed[]
     */
    public $rules = [];

    /**
     * Errors from validation
     *
     * @var mixed[]
     */
    private $errors = [];

    /**
     * Get validation errors array
     *
     * @return mixed[] Validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Validate a repository
     *
     * @param mixed[] $data    The data to validate
     * @param mixed[] $ruleset The ruleset to validate against
     *
     * @return bool Whether the validation passes or fails
     */
    public function validate(array $data, array $ruleset): bool
    {
        // Reset errors
        $this->errors = [];

        // Break/format rules into a readable format
        $this->parseRules($ruleset);

        // Perform validation against remaining rules
        /**
         * @var string $attribute
         * @var array $rules
         */
        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule => $parameters) {
                /** @var \LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rule $rule */
                $rule = new $rule($attribute, $parameters, $data);

                if ($rule->validate() === false) {
                    // Allow multiple errors per attribute
                    if (\array_key_exists($attribute, $this->errors) === false
                        || \is_array($this->errors[$attribute]) === false
                    ) {
                        $this->errors[$attribute] = [];
                    }

                    $this->errors[$attribute][] = $rule->getError();
                }
            }
        }

        // Return result based on errors
        return \count($this->errors) === 0;
    }

    /**
     * Convert the rules into a more readable format
     *
     * @param mixed[] $ruleset The ruleset to parse
     *
     * @return void
     */
    private function parseRules(array $ruleset): void
    {
        foreach ($ruleset as $attribute => $rules) {
            // If rules aren't an array parse string
            if (\is_array($rules) === false) {
                $rules = $this->parseRuleString($rules);
            }

            // Set up placeholder for attribute
            $this->rules[$attribute] = [];

            // Rules which require a parameter array
            $parameterArrayRules = ['enum', 'in', 'requiredWith', 'requiredWithout', 'type'];

            // Process each rule
            foreach ($rules as $rule => $parameters) {
                // If rule is numeric it's an array without parameters
                if (\is_numeric($rule)) {
                    $rule = $parameters;
                    $parameters = null;
                }

                // Sort out parameters if the rule requires an array
                if (\is_string($parameters) && \in_array($rule, $parameterArrayRules, true)) {
                    $parameters = \explode(',', $parameters);
                }

                // Attempt to find rule class from rule name
                $namespaced = 'LoyaltyCorp\\SdkBlueprint\\Sdk\\Validation\\Rules\\' . \ucfirst($rule);
                if (\class_exists($namespaced) === false) {
                    // Rule is unknown, add as error
                    $this->errors[] = \sprintf("Unknown rule '%s' used for validation", $rule);
                    continue;
                }

                // Add rule to rules array
                $this->rules[$attribute][$namespaced] = $parameters;
            }
        }
    }

    /**
     * Convert the rule string into a more readable format.
     *
     * @param string $rule
     *
     * @return string[]
     */
    private function parseRuleString(string $rule): array
    {
        $rulesArray = \explode('|', $rule);
        $rules = [];
        foreach ($rulesArray as $ruleString) {
            // Update the logic that uses $matches array If you change the pattern used in \preg_match_all().
            \preg_match_all('/([a-zA-Z\d]+)(?:\:(\S+))?/', (string)$ruleString, $matches);

            // Based on the pattern we used above, we are expecting $matches array has indexes 0, 1 and 2.
            // Update the logic that you use the $matches array if you changed the pattern above.
            foreach (\array_keys($matches[0]) as $key) {
                $rules[$matches[1][$key]] = $matches[2][$key];
            }
        }

        return $rules;
    }
}
