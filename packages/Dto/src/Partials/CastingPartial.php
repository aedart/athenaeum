<?php

namespace Aedart\Dto\Partials;

use Aedart\Utils\Json;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use JsonException;
use Throwable;

/**
 * Casting Partial
 *
 * Deals with property value casting.
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
     *
     * @return mixed
     *
     * @throws JsonException
     * @throws BindingResolutionException|Throwable
     */
    protected function castPropertyValue(string $name, mixed $value): mixed
    {
        // Get the type to cast to, if one exists.
        // If none type has been set, then just return
        // the value as it is.
        if (!isset($this->allowed[$name]) || is_null($value)) {
            return $value;
        }

        // Cast value to assigned type
        $type = $this->allowed[$name];
        return match ($type) {
            'string', 'str' => $this->castAsString($value),
            'integer', 'int' => $this->castAsInteger($value),
            'float', 'double' => $this->castAsFloat($value),
            'boolean', 'bool' => $this->castAsBoolean($value),
            'array' => $this->castAsArray($value),
            'date' => $this->castAsDate($value),

            // We assume that it's an object that must be resolved via the IoC
            default => $this->resolveClassAndPopulate($type, $name, $value)
        };
    }

    /**
     * Cast given value to a string
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function castAsString(mixed $value): string
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
    protected function castAsInteger(mixed $value): int
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
    protected function castAsFloat(mixed $value): float
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
    protected function castAsBoolean(mixed $value): bool
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
    protected function castAsArray(string|array $value): array
    {
        if (is_array($value)) {
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
    protected function castAsDate(string|null $value): Carbon|DateTimeInterface
    {
        return Carbon::parse($value);
    }
}
