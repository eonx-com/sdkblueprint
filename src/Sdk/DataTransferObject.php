<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Utils\Str;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedMethodException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableObjectInterface;

abstract class DataTransferObject
{
    /**
     * Attributes of the DTO.
     *
     * @var mixed[] $attributes
     */
    protected $attributes = [];

    /**
     * All validation rules of the DTO.
     *
     * @var string[] $rules
     */
    protected $rules = [];

    /**
     * Instantiate the object and fill all its attributes by given data.
     *
     * @param mixed[]|null $data
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
    public function __construct(?array $data = null)
    {
        // If not data has been passed there is nothing to do
        if (\is_array($data) === false) {
            return;
        }

        $this->fill($data);
    }

    /**
     * Call a getter or a setter.
     *
     * @param string  $method
     * @param mixed[] $parameters
     *
     * @return mixed - it returns the object itself when it is a setter
     *                 and it returns string, boolean, float etc. if it is a getter.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedMethodException
     */
    public function __call(string $method, array $parameters)
    {
        // Set available types
        $types = ['get', 'set'];

        // Break calling method into type (get, has, is, set) and attribute
        \preg_match('/^(' . \implode('|', $types) . ')([\da-z_]+)/i', $method, $matches);
        $type = \mb_strtolower($matches[1] ?? '');
        $attribute = $matches[2] ?? '';

        if ($type === null || $this->hasAttribute($attribute) === false) {
            throw new UndefinedMethodException(\sprintf('%s method not supported', $method));
        }

        $parameter = $this->resolveParameters($type, $parameters);
        return $this->$type($attribute, $parameter);
    }

    /**
     * Set all allowed attributes.
     *
     * @return string[]
     */
    abstract protected function hasAttributes(): array;

    /**
     * Set all required validation rules.
     *
     * @return string[]
     */
    abstract public function hasValidationRules(): array;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this->attributes as $attribute => $value) {
            if (($this instanceof AssemblableObjectInterface) === false) {
                $array[$attribute] = $value;
                continue;
            }

            /*** @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableObjectInterface $this */
            $embedObjects = $this->embedObjects();

            if (isset($embedObjects[$attribute]) === false) {
                $array[$attribute] = $value;
                continue;
            }

            /** @var \LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject $value */
            $array[$attribute] = $value->toArray();
        }

        return $array;
    }

    /**
     * The getter.
     *
     * @param string $attribute
     *
     * @return mixed
     */
    protected function get(string $attribute)
    {
        $attribute = $this->formatAttribute($attribute);
        return isset($this->attributes[$attribute]) === true ? $this->attributes[$attribute] : null;
    }

    /**
     * Fill attributes if they are valid.
     *
     * @param mixed[] $data
     *
     * @return $this
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
    protected function fill(array $data): self
    {
        foreach ($this->fillableFromArray($data) as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Get the fillable attributes of a given array.
     *
     * @param mixed[] $data
     *
     * @return mixed[]
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\EmptyAttributesException
     */
    protected function fillableFromArray(array $data): array
    {
        if (\count($this->hasAttributes()) === 0) {
            throw new EmptyAttributesException('Object should have at least one attribute');
        }

        return \array_intersect_key($data, \array_flip($this->hasAttributes()));
    }

    /**
     * Format attribute to lower case and snake case.
     *
     * @param string $attribute
     *
     * @return string
     */
    protected function formatAttribute(string $attribute): string
    {
        return (new Str())->snake(\strtolower($attribute));
    }

    /**
     * Check whether the DTO has the attribute.
     *
     * @param string $attribute
     *
     * @return bool
     */
    protected function hasAttribute(string $attribute): bool
    {
        if (\in_array($this->formatAttribute($attribute), $this->hasAttributes(), true)) {
            return true;
        }

        return false;
    }

    /**
     * Get the required parameter for getter or setter.
     *
     * @param string  $type
     * @param mixed[] $parameters
     *
     * @return mixed|null
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException
     */
    protected function resolveParameters(string $type, array $parameters)
    {
        $this->validateParametersNumber($type === 'set' ? 1 : 0, $parameters);

        return $type === 'set' ? $parameters[0] : null;
    }

    /**
     * The setter.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return $this
     */
    protected function set(string $attribute, $value): self
    {
        return $this->setAttribute($attribute, $value);
    }

    /**
     * Set a value of the attribute.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    protected function setAttribute(string $key, $value): self
    {
        $key = $this->formatAttribute($key);

        // If it is just a DTO that doesn't include any other DTO, simply assign the value to the attribute.
        if (($this instanceof AssemblableObjectInterface) === false) {
            $this->attributes[$key] = $value;
            return $this;
        }

        //DTO which includes other DTOs, so we need to resolve nested attributes value.
        /** @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableObjectInterface $this */
        $embedObjects = $this->embedObjects();

        if (isset($embedObjects[$key]) === false) {
            $this->attributes[$key] = $value;
            return $this;
        }

        //If the given value is already an object, we assign to the attribute directly.
        if (\is_object($value)) {
            $this->attributes[$key] = $value;
            return $this;
        }

        $this->attributes[$key] = new $embedObjects[$key]($value);
        return $this;
    }

    /**
     * Validate the number of parameters of a method.
     *
     * @param int     $expectsNumber
     * @param mixed[] $parameters
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException
     */
    protected function validateParametersNumber(int $expectsNumber, array $parameters): void
    {
        $numberOfParameters = \count($parameters);

        if ($numberOfParameters !== $expectsNumber) {
            throw new InvalidArgumentException(
                \sprintf('expects %s number of parameters, %s given', $expectsNumber, $numberOfParameters)
            );
        }
    }
}
