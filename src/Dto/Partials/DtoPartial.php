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
 * <br />
 *
 * Contains common Dto methods.
 *
 * <br />
 *
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
     * <br />
     *
     * If an empty array is provided, nothing is populated.
     *
     * <br />
     *
     * If a value or property is not given via $data, then it
     * is NOT modified / changed.
     *
     * <br />
     *
     * <pre>
     *      $myComponent->populate([
     *          'myProperty' => 'myPropertyValue',
     *          'myOtherProperty' => 42.5
     *      ])
     * </pre>
     *
     * @param array $data [optional] Key-value pair, key = property name, value = property value
     *
     * @return void
     *
     * @throws Throwable In case that one or more of the given array entries are invalid
     */
    public function populate(array $data = []): void
    {
        foreach ($data as $property => $value){
            $this->__set($property, $value);
        }
    }

    /**
     * Returns a new instance of this Dto
     *
     * @param array $properties [optional]
     * @param Container|null $container [optional]
     *
     * @return static
     */
    public static function makeNew(array $properties = [], ?Container $container = null)
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
    public static function fromJson(string $json)
    {
        return static::makeNew(Json::decode($json, true));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $properties = $this->populatableProperties();
        $output = [];

        foreach ($properties as $property) {
            // Make sure that property is not unset
            if ( ! isset($this->$property)) {
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
    public function toJson($options = 0)
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array_map(function($value){

            if($value instanceof JsonSerializable){
                return $value->jsonSerialize();
            } elseif($value instanceof Arrayable){
                return $value->toArray();
            }

            return $value;
        }, $this->toArray());
    }

    /**
     * Returns a this the serialised representation of this DTO
     *
     * @return string
     */
    public function serialize() : string
    {
        return serialize($this->toArray());
    }

    /**
     * Populate this DTO with given serialised data
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->populate($data);
    }

    /**
     * Returns a string representation of this Data Transfer Object
     *
     * @return string
     *
     * @throws JsonException
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Debug info
     *
     * @return array
     */
    public function __debugInfo() : array
    {
        return $this->toArray();
    }

    /*****************************************************************
     * Array Access Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}
