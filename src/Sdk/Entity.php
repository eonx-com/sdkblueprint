<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Utils\Arr;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidMethodCallException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;

abstract class Entity implements EntityInterface
{
    /**
     * Create a new object.
     *
     * @param mixed[]|null $data The data to populate the object with
     */
    public function __construct(?array $data = null)
    {
        $this->fill($data ?? []);
    }

    /**
     * Allow getX() and setX($value) to get and set column values.
     *
     * This method searches case insensitive
     *
     * @param string $method The method being called
     * @param mixed[] $parameters Parameters passed to the method
     *
     * @return mixed Value or null on getX(), self on setX(value)
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidMethodCallException If the method doesn't exist
     */
    public function __call(string $method, array $parameters)
    {
        // Set available types
        $types = ['get', 'has', 'is', 'set'];

        // Break calling method into type (get, has, is, set) and attribute
        \preg_match('/^(' . \implode('|', $types) . ')([a-zA-Z][\w]+)$/i', $method, $matches);

        $type = \mb_strtolower($matches[1] ?? '');
        $property = $this->resolveProperty($matches[2] ?? '');

        // The property being accessed must exist and the type must be valid if one of these things
        // aren't true throw an exception
        if ($type === '' || $property === null) {
            throw new InvalidMethodCallException(
                \sprintf('Call to undefined method %s::%s()', \get_class($this), $method)
            );
        }

        // Perform action
        switch ($type) {
            case 'get': //@codeCoverageIgnore
                return $this->__get($property);

            case 'has': //@codeCoverageIgnore
                return $this->has($property);

            case 'is': //@codeCoverageIgnore
                // Always return a boolean
                return (bool)$this->__get($property);

            case 'set': //@codeCoverageIgnore
                // Return original instance for fluency
                $this->__set($property, \reset($parameters));

                break;
        }

        return $this;
    }

    /**
     * Magic getter for serializer to access protected attribute.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        $resolved = $this->resolveProperty($property);

        return $resolved !== null ? $this->{$resolved} : null;
    }

    /**
     * Determine if a property exists and isn't null.
     *
     * @param string $property
     *
     * @return bool
     */
    public function __isset(string $property): bool
    {
        $resolved = $this->resolveProperty($property);

        return $resolved !== null && $this->{$resolved} !== null;
    }

    /**
     * Magic getter for serializer to set value for protected attribute.
     *
     * @param string $property
     * @param mixed $value
     *
     * @return static
     */
    public function __set(string $property, $value)
    {
        $resolved = $this->resolveProperty($property);

        if ($resolved !== null) {
            $this->{$resolved} = $value;
        }

        return $this;
    }

    /**
     * Populate the object from an array of data.
     *
     * @param mixed[] $data The data to fill the entity with
     *
     * @return void
     */
    public function fill(array $data): void
    {
        // Loop through data and set values, set will automatically skip invalid or non-fillable properties
        foreach ($data as $property => $value) {
            $this->__set($property, $value);
        }
    }

    /**
     * Determine if a property exists.
     *
     * @param string $property
     *
     * @return bool
     */
    private function has(string $property): bool
    {
        return $this->resolveProperty($property) !== null;
    }

    /**
     * Resolve property without case sensitivity or special characters, resolves property such as
     * addressStreet to addressstreet, address_street or ADDRESSSTREET.
     *
     * @param string $property The property to resolve
     *
     * @return string|null
     */
    private function resolveProperty(string $property): ?string
    {
        // Attempt to find property using 'fuzzy' search
        return (new Arr())->search(\array_keys(\get_object_vars($this)), $property);
    }
}
