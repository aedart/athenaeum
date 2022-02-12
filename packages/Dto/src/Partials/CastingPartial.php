<?php

namespace Aedart\Dto\Partials;

use Aedart\Utils\Json;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use JsonException;
use LogicException;
use Throwable;
use TypeError;

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
     * "no match" identifier
     */
    private static string $noMatch = '|@no_match@|';

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
        if ($this->isUnionType($type)) {
            return $this->resolveUnionType($type, $name, $value);
        }

        return match ($type) {
            'string', 'str' => $this->castAsString($value),
            'integer', 'int' => $this->castAsInteger($value),
            'float', 'double' => $this->castAsFloat($value),
            'boolean', 'bool' => $this->castAsBoolean($value),
            'array', 'arr' => $this->castAsArray($value),
            'date' => $this->castAsDate($value),

            // Not sure when this ever will be useful, but we allow it...
            'null' && is_null($value) => null,

            // We assume that it's an object that must be resolved via the IoC
            default => $this->resolveClassAndPopulate($type, $name, $value)
        };
    }

    /**
     * Determine if type is a union type
     *
     * @param string|array $type
     *
     * @return bool
     */
    protected function isUnionType(string|array $type): bool
    {
        return is_array($type) || str_contains($type, '|');
    }

    /**
     * Resolve union type
     *
     * @param  string|array  $allowedTypes List of allowed data types
     * @param  string $name Name of property
     * @param  mixed $value Value to cast
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws JsonException
     * @throws Throwable
     */
    protected function resolveUnionType(string|array $allowedTypes, string $name, mixed $value): mixed
    {
        if (is_string($allowedTypes)) {
            $allowedTypes = explode('|', $allowedTypes);
        }

        if (empty($allowedTypes)) {
            throw new LogicException(sprintf('Invalid allowed union types declared for %s', $name));
        }

        foreach ($allowedTypes as $type) {

            $result = match(true) {
                in_array($type, ['string', 'str']) && is_string($value) => $this->castAsString($value),
                in_array($type, ['integer', 'int']) && is_integer($value) => $this->castAsInteger($value),
                in_array($type, ['float', 'double']) && is_float($value) => $this->castAsFloat($value),
                in_array($type, ['boolean', 'bool']) && is_bool($value) => $this->castAsBoolean($value),
                in_array($type, ['array', 'arr']) && (is_array($value) || is_string($value)) => $this->castAsArray($value),
                $type === 'date' && ($value instanceof DateTimeInterface || is_string($value)) => $this->castAsDate($value),
                $type === 'null' && is_null($value) => null,

                // When type is a class path and value is an instance of the type...
                class_exists($type) && is_object($value) && $value instanceof $type => $this->resolveClassAndPopulate($type, $name, $value),

                // When type is a class and an array value is given, we assume that type is a DTO or populate instance.
                class_exists($type) && is_array($value) => $this->attemptPopulateDtoWithArray($type, $name, $value),

                // Otherwise, we need to skip and allow next type to be processed
                default => static::$noMatch
            };

            if ($result !== static::$noMatch) {
                return $result;
            }
        }

        // This means that everything else has failed, and we do not know how to handle the given type.
        throw new TypeError(sprintf(
            'Unable to set property $%s. %s expected, but was %s given.',
            $name,
            implode('|', $allowedTypes),
            var_export($value, true)
        ));
    }

    /**
     * Attempt to populate a user-defined class, e.g. DTO or populatable with array
     * data
     *
     * @param  string  $type
     * @param  string  $parameter
     * @param  array  $value
     *
     * @return mixed Populated DTO or returns "no match" identifier when no able to populate given type
     *
     * @throws BindingResolutionException
     * @throws Throwable
     */
    protected function attemptPopulateDtoWithArray(string $type, string $parameter, array $value): mixed
    {
        $resolved = $this->attemptPopulateUserDefinedClass($type, $parameter, $value);
        if (!isset($resolved)) {
            return static::$noMatch;
        }

        return $resolved;
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
     * @param string|DateTimeInterface|null $value
     *
     * @return Carbon|DateTimeInterface
     */
    protected function castAsDate(string|DateTimeInterface|null $value): Carbon|DateTimeInterface
    {
        return Carbon::parse($value);
    }
}
