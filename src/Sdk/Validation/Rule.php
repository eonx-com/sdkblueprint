<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Validation;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren) All rules extend this class
 */
abstract class Rule
{
    /**
     * The attribute being tested
     *
     * @var string
     */
    protected $attribute;

    /**
     * The full data for all attributes in the repository/resource
     *
     * @var mixed[]
     */
    protected $data;

    /**
     * The error returned by the validation
     *
     * @var string
     */
    protected $error = '';

    /**
     * The rule parameters to use while validating
     *
     * @var mixed
     */
    protected $parameters;

    /**
     * Create a new rule instance
     *
     * @param string  $attribute  The attribute being tested
     * @param mixed   $parameters Parameters to use when validating
     * @param mixed[] $data       The full data for all attributes in the repository/resource
     */
    public function __construct(string $attribute, $parameters, array $data)
    {
        $this->attribute = $attribute;
        $this->data = $data;
        $this->parameters = $parameters;
    }

    /**
     * Return the error set by the rule
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Run validation against a rule
     *
     * @return bool The validation result
     */
    public function validate(): bool
    {
        // Process rule
        $this->process();

        return $this->error === '';
    }

    /**
     * Process the rule
     *
     * @return void
     */
    abstract protected function process(): void;

    /**
     * Get the value of an attribute from the data array
     *
     * @param string|null $attribute An attribute to check, null will use the primary attribute being validated
     *
     * @return mixed The value from the data array or an empty string if no value exists
     */
    protected function getValue(?string $attribute = null)
    {
        // Use validation attribute if no attribute is provided
        $attribute = \mb_strtolower($attribute ?? $this->attribute);

        foreach (\array_keys($this->data) as $key) {
            if (\mb_strtolower($key) === $attribute) {
                return $this->data[$key];
            }
        }

        return '';
    }

    /**
     * Determine if an attribute exists in the data array and has a value
     *
     * @return bool
     */
    protected function hasValue(): bool
    {
        // Preserve zero values and empty arrays
        return (\is_numeric($this->getValue()) && (string)$this->getValue() === '0') ||
            \is_array($this->getValue()) ||
            (bool)$this->getValue();
    }
}
