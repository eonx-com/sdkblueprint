<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Utils\Str;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedMethodException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableObjectInterface;

abstract class DataTransferObject
{
    protected $attributes = [];
    protected $rules = [];

    public function __construct(array $data = null)
    {
        // If not data has been passed there is nothing to do
        if (!\is_array($data)) {
            return;
        }

        $this->fill($data);
    }

    /**
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws UndefinedMethodException
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
     * @return array
     */
    abstract protected function hasAttributes(): array;

    /**
     * @return array
     */
    abstract protected function getValidationRules(): array;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this->attributes as $attribute => $value) {
            if (($this instanceof AssemblableObjectInterface) === false) {
                $array[$attribute] = $value;
                continue;
            }

            /** @var AssemblableObjectInterface $this */
            $embedObjects = $this->embedObjects();

            if (!isset($embedObjects[$attribute])) {
                $array[$attribute] = $value;
                continue;
            }

            /** @var DataTransferObject $value  */
            $array[$attribute] = $value->toArray();
        }

        return $array;
    }

    /**
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
     * @param array $data
     *
     * @return DataTransferObject
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
     * @param  array  $data
     *
     * @return array
     */
    protected function fillableFromArray(array $data): array
    {
        if (count($this->hasAttributes()) > 0) {
            return \array_intersect_key($data, \array_flip($this->hasAttributes()));
        }
        return $data;
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
     * @param string $type
     * @param array $parameters
     *
     * @return mixed|null
     *
     * @throws InvalidArgumentException
     */
    protected function resolveParameters(string $type, array $parameters)
    {
        $this->validateParameters($type === 'set' ? 1 : 0, $parameters);

        return $type === 'set' ? $parameters[0] : null;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return DataTransferObject
     */
    protected function set(string $attribute, $value): self
    {
        return $this->setAttribute($attribute, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    protected function setAttribute(string $key, $value): self
    {
        $key = $this->formatAttribute($key);

        if ($this->hasAttribute($key) === false()) {
            return $this;
        }

        if (($this instanceof AssemblableObjectInterface) === false) {
            $this->attributes[$key] = $value;
            return $this;
        }

        /** @var AssemblableObjectInterface $this */
        $embedObjects = $this->embedObjects();

        if (isset($embedObjects[$key]) === false) {
            $this->attributes[$key] = $value;
            return $this;
        }

        $this->attributes[$key] = new $embedObjects[$key]($value);
        return $this;
    }

    /**
     * @param int $expectsNumber
     * @param array $parameters
     *
     * @throws InvalidArgumentException
     */
    protected function validateParameters(int $expectsNumber, array $parameters): void
    {
        $numberOfParameters = \count($parameters);

        if ($numberOfParameters !== $expectsNumber) {
            throw new InvalidArgumentException(
                \sprintf('expects %s number of parameters, %s given', $expectsNumber, $numberOfParameters)
            );
        }
    }
}
