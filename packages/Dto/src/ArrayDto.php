<?php

namespace Aedart\Dto;

use Aedart\Contracts\Dto;
use Aedart\Dto\Exceptions\UndefinedProperty;
use Aedart\Utils\Helpers\MethodHelper;
use Aedart\Utils\Json;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use JsonException;
use JsonSerializable;
use ReflectionException;
use Throwable;

/**
 * Abstract Data Transfer Object (Array version)
 *
 * @see \Aedart\Contracts\Dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto
 */
abstract class ArrayDto implements Dto
{
    use Concerns\Dependencies;
    use Concerns\Casting;

    /**
     * The properties of this Dto
     *
     * @var array<string, mixed> Key = property's name, value = property's value
     */
    protected array $properties = [];

    /**
     * Defines the allowed properties and their data type.
     *
     * **Example**
     * ```
     *  [
     *       'name'      => 'string',
     *       'age'       => 'int',
     *       'address'   => \Acme\Dto\Address::class
     *  ]
     * ```
     *
     * @var array<string, mixed>
     */
    protected array $allowed = [];

    /**
     * ArrayDto constructor.
     *
     * @param array $properties [optional]
     * @param Container|null $container [optional]
     *
     * @throws Throwable
     */
    public function __construct(array $properties = [], Container|null $container = null)
    {
        $this
            ->setContainer($container)
            ->populate($properties);
    }

    /**
     * @inheritdoc
     *
     * @throws Throwable
     */
    public static function makeNew(array $properties = [], Container|null $container = null): static
    {
        return new static($properties, $container);
    }

    /**
     * @inheritdoc
     *
     * @throws Throwable
     */
    public static function fromJson(string $json): static
    {
        return static::makeNew(Json::decode($json, true));
    }

    /**
     * @inheritdoc
     */
    public function populate(array $data = []): static
    {
        foreach ($data as $property => $value) {
            $this->__set($property, $value);
        }

        return $this;
    }

    /**
     * Returns a list of the properties / attributes that can be populated
     *
     * @return string[]
     *
     * @see populate()
     */
    public function populatableProperties(): array
    {
        return array_keys($this->allowed);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $properties = $this->populatableProperties();
        $output = [];

        foreach ($properties as $property) {
            // Make sure that property is not unset
            if (!isset($this->{$property})) {
                continue;
            }

            // Ensure to obtain value via evt. getter method
            $output[$property] = $this->__get($property);
        }

        return $output;
    }

    /**
     * @inheritdoc
     *
     * @throws JsonException
     */
    public function toJson($options = 0): string
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): mixed
    {
        return array_map(function ($value) {
            return match (true) {
                $value instanceof JsonSerializable => $value->jsonSerialize(),
                $value instanceof Arrayable => $value->toArray(),
                default => $value,
            };
        }, $this->toArray());
    }

    /*****************************************************************
     * Array Access Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->__isset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->__get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->__set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->__unset($offset);
    }

    /*****************************************************************
     * Magic Methods
     ****************************************************************/

    /**
     * Set property
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     *
     * @throws UndefinedProperty
     * @throws BindingResolutionException
     * @throws ReflectionException
     * @throws Throwable
     */
    public function __set(string $name, mixed $value): void
    {
        // Abort if not allowed.
        if (!array_key_exists($name, $this->allowed)) {
            throw new UndefinedProperty(sprintf('Property "%s" is not supported (not allowed)', $name));
        }

        // Invoke mutator, if one exists.
        $mutator = MethodHelper::makeSetterName($name);
        if (method_exists($this, $mutator)) {
            $this->{$mutator}($this->resolveValue($mutator, $value));
            return;
        }

        // Otherwise, cast value and set it.
        $this->properties[$name] = $this->castPropertyValue($name, $value);
    }

    /**
     * Get property
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws UndefinedProperty
     */
    public function __get(string $name): mixed
    {
        // Abort if not allowed.
        if (!array_key_exists($name, $this->allowed)) {
            throw new UndefinedProperty(sprintf('Property "%s" is not supported (not allowed)', $name));
        }

        // Invoke accessor, if one exists.
        $accessor = MethodHelper::makeGetterName($name);
        if (method_exists($this, $accessor)) {
            return $this->{$accessor}();
        }

        // Otherwise, return property if a value exists or
        // simply return null.
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * Determine if property has been set
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * Unset property
     *
     * @param string $name
     */
    public function __unset(string $name): void
    {
        unset($this->properties[$name]);
    }

    /**
     * Returns the data to be serialized
     *
     * @return array
     */
    public function __serialize(): array
    {
        // Filter off properties that have "null" as value!
        // Those might cause undesired unserialize effect,
        // in case of nested Dto instances...
        return array_filter($this->toArray(), fn ($value) => isset($value));
    }

    /**
     * Populates this DTO with unserialized data
     *
     * @param array $data
     *
     * @throws Throwable
     */
    public function __unserialize(array $data): void
    {
        $this->populate($data);
    }

    /**
     * @inheritdoc
     *
     * @throws JsonException
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * Debug info
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }
}
