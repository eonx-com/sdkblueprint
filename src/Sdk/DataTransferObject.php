<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Utils\Str;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidAttributeException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\MethodNotSupportedException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableInterface;

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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidAttributeException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\MethodNotSupportedException
     */
    public function __call(string $method, array $parameters)
    {
        // Set available types
        $types = ['get', 'set'];

        // Break calling method into type (get, has, is, set) and attribute
        \preg_match('/^(' . \implode('|', $types) . ')([\da-z_]+)/i', $method, $matches);
        $type = \mb_strtolower($matches[1] ?? '');
        $attribute = $matches[2] ?? '';

        if (!\in_array($type, $types, true)) {
            throw new MethodNotSupportedException(\sprintf('%s method not supported', $method));
        }

        $attribute = $this->formatAttribute($attribute);

        if ($type === 'set') {
            $this->set($method, $attribute, $parameters);
        }

        if ($type === 'get') {
            return $this->get($method, $attribute, $parameters);
        }
    }

    /**
     * @param string $method
     * @param string $attribute
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidArgumentException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidAttributeException
     */
    protected function get(string $method, string $attribute, array $parameters)
    {
        $numberOfParameters = \count($parameters);

        if ($numberOfParameters !== 0) {
            throw new InvalidArgumentException(
                \sprintf('%s method expects 0 argument, %s are given', $method, $numberOfParameters)
            );
        }

        if (!$this->hasAttribute($attribute)) {
            throw new InvalidAttributeException(\sprintf('%s is not a valid attribute of %s', $attribute, self::class));
        }

        if (!\array_key_exists($attribute, $this->attributes)) {
            return null;
        }

        return $this->attributes[$attribute];
    }

    /**
     * @param string $method
     * @param string $attribute
     * @param array $parameters
     *
     * @return DataTransferObject
     *
     * @throws InvalidArgumentException
     * @throws InvalidAttributeException
     */
    protected function set(string $method, string $attribute, array $parameters): self
    {
        $numberOfParameters = \count($parameters);

        if ($numberOfParameters !== 1) {
            throw new InvalidArgumentException(
                \sprintf('%s method only expect 1 argument, %s are given', $method, $numberOfParameters)
            );
        }

        if (!$this->hasAttribute($attribute)) {
            throw new InvalidAttributeException(\sprintf('%s is not a valid attribute of %s', $attribute, self::class));
        }

        return $this->setAttribute($attribute, $parameters[0]);
    }

    /**
     * @return array
     */
    abstract protected function getFillable(): array;

    /**
     * @return array
     */
    abstract protected function getValidationRules(): array;

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
        if (count($this->getFillable()) > 0) {
            return \array_intersect_key($data, \array_flip($this->getFillable()));
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
        if (\in_array($attribute, $this->getFillable(), true)) {
            return true;
        }

        return false;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    protected function setAttribute($key, $value): self
    {
        $key = $this->formatAttribute($key);

        if ($this->hasAttribute($key)) {
            if (!($this instanceof AssemblableInterface)) {
                $this->attributes[$key] = $value;
                return $this;
            }


            $embedObjects = $this->embed();

            if (!isset($embedObjects[$key])) {
                $this->attributes[$key] = $value;
                return $this;
            }

            $this->attributes[$key] = new $embedObjects[$key]($value);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        $attributes = $this->attributes;

        if ($this instanceof AssemblableInterface) {
            $attributes = \array_merge($attributes, $this->embed());
        }

        foreach ($attributes as $attribute => $value) {
            $array[$attribute] = $value;
        }

        return $array;
    }
}
