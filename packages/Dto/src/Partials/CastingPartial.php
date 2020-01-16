<?php

namespace Aedart\Dto\Partials;

use Aedart\Utils\Json;
use Carbon\Carbon;
use DateTimeInterface;
use JsonException;

/**
 * Casting Partial
 *
 * <br />
 *
 * Deals with property value casting
 *
 * <br />
 *
 * This partial is intended for the Dto abstraction(s)
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto\Partials
 */
trait CastingPartial
{
    /**
     * Cast given property's value
     *
     * @param string $name Name of property
     * @param mixed $value Value to cast
     * @return bool|float|int|mixed|string
     *
     * @throws JsonException
     */
    protected function castPropertyValue(string $name, $value)
    {
        // Get the type to cast to, if one exists.
        // If none type has been set, then just return
        // the value as it is.
        if( ! isset($this->allowed[$name]) || is_null($value)){
            return $value;
        }

        // Cast value to assigned type
        $type = $this->allowed[$name];
        switch ($type){
            case 'string':
            case 'str':
                return $this->castAsString($value);

            case 'int':
            case 'integer':
                return $this->castAsInteger($value);

            case 'float':
            case 'double':
                return $this->castAsFloat($value);

            case 'bool':
            case 'boolean':
                return $this->castAsBoolean($value);

            case 'array':
                return $this->castAsArray($value);

            case 'date':
                return $this->castAsDate($value);

            // We assume that it's an object that must be
            // resolved via the IoC
            default:
                return $this->resolveClassAndPopulate($type, $name, $value);
        }
    }

    /**
     * Cast given value to a string
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function castAsString($value) : string
    {
        return (string) $value;
    }

    /**
     * Cast given value to an integer
     *
     * @param mixed $value
     *
     * @return int
     */
    protected function castAsInteger($value) : int
    {
        return (int) $value;
    }

    /**
     * Cast given value to a float
     *
     * @param mixed $value
     *
     * @return float
     */
    protected function castAsFloat($value) : float
    {
        return (float) $value;
    }

    /**
     * Cast given value to a boolean
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function castAsBoolean($value) : bool
    {
        return (bool) $value;
    }

    /**
     * Cast given value to an array
     *
     * @param string|array $value
     * @return array
     *
     * @throws JsonException
     */
    protected function castAsArray($value) : array
    {
        if(is_array($value)){
            return $value;
        }

        return Json::decode($value, true);
    }

    /**
     * Cast given value to a DateTime instance
     *
     * @param string|null $value
     *
     * @return Carbon|DateTimeInterface
     */
    protected function castAsDate($value)
    {
        return Carbon::parse($value);
    }
}
