<?php

namespace Aedart\Dto\Partials;


use Aedart\Utils\Exceptions\JsonEncoding;
use Aedart\Utils\Json;
use Carbon\Carbon;
use DateTimeInterface;

trait CastingPartial
{
    /**
     * Cast given property's value
     *
     * @param string $name Name of property
     * @param mixed $value Value to cast
     * @return bool|float|int|mixed|string
     *
     * @throws BindingResolutionException
     * @throws Throwable
     * @throws JsonEncoding
     */
    protected function castPropertyValue(string $name, $value)
    {
        // Get the type to cast to, if one exists.
        // If none type has been set, then just return
        // the value as it is.
        if( ! isset($this->allowed[$name]) || is_null($value)){
            return $value;
        }

        $type = $this->allowed[$name];
        switch ($type){
            case 'string':
            case 'str':
                return (string) $value;

            case 'integer':
            case 'int':
                return (int) $value;

            case 'float':
            case 'double':
                return (float) $value;

            case 'boolean':
            case 'bool':
                return (bool) $value;

            case 'array':
                return $this->castAsArray($value);

            case 'date':
                return $this->castAsDate($value);

            // We assume that it's an object that must be
            // resolved via the IoC
            default:
                $instance = $this->container()->make($type);
                return $this->resolveInstancePopulation($instance, $name, $value);
        }
    }

    /**
     * Cast given value as array
     *
     * @param string|array $value
     * @return array
     *
     * @throws JsonEncoding
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
