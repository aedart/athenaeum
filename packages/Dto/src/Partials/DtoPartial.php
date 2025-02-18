<?php

namespace Aedart\Dto\Partials;

use Aedart\Utils\Json;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use JsonException;
use JsonSerializable;

/**
 * Dto Partial
 *
 * Contains common Dto methods.
 * This partial is intended for the Dto abstraction(s)
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto\Partials
 */
trait DtoPartial
{
    /**
     * Populate this component via an array
     *
     * If an empty array is provided, nothing is populated.
     *
     * If a value or property is not given via $data, then it
     * is NOT modified / changed.
     *
     * Example:
     * ```
     *      $myComponent->populate([
     *          'myProperty' => 'myPropertyValue',
     *          'myOtherProperty' => 42.5
     *      ])
     * ```
     *
     * @param array $data [optional] Key-value pair, key = property name, value = property value
     *
     * @return self
     *
     * @throws Throwable In case that one or more of the given array entries are invalid
     */
    public function populate(array $data = []): static
    {
        foreach ($data as $property => $value) {
            $this->__set($property, $value);
        }

        return $this;
    }

    /**
     * Returns a new instance of this Dto
     *
     * @param array $properties [optional]
     * @param Container|null $container [optional]
     *
     * @return static
     */
    public static function makeNew(array $properties = [], Container|null $container = null): static
    {
        return new static($properties, $container);
    }

    /**
     * Create a new populated instance of this Dto from a
     * json encoded string
     *
     * @param string $json
     *
     * @return static
     *
     * @throws JsonException
     */
    public static function fromJson(string $json): static
    {
        return static::makeNew(Json::decode($json, true));
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
            if ($this->isPropertyUnset($property)) {
                continue;
            }

            // Ensure to obtain value via evt. getter method
            $output[$property] = $this->__get($property);
        }

        return $output;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
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
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            }

            return $value;
        }, $this->toArray());
    }

    /**
     * Returns the data this DTO chooses to have serialised
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
     */
    public function __unserialize(array $data): void
    {
        $this->populate($data);
    }

    /**
     * Returns a string representation of this Data Transfer Object
     *
     * @return string
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

    /*****************************************************************
     * Array Access Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->$offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine if the given property has been unset
     *
     * @param string $property
     *
     * @return bool
     */
    protected function isPropertyUnset(string $property): bool
    {
        return !property_exists($this, $property);
    }
}
