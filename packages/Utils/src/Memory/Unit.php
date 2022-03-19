<?php

namespace Aedart\Utils\Memory;

use InvalidArgumentException;
use Stringable;

/**
 * Memory Unit (immutable)
 *
 * @see https://en.wikipedia.org/wiki/Byte#Multiple-byte_units
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Memory
 */
class Unit implements Stringable
{
    /**
     * Default units on powers of 10
     *
     * Source: https://en.wikipedia.org/wiki/Byte
     */
    public const UNITS_POWER_OF_10 = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    /**
     * Default units on powers of 2
     *
     * Source: https://en.wikipedia.org/wiki/Byte
     */
    public const UNITS_POWER_OF_2 = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];

    /**
     * Units based on powers of 10, in which 1 kilobyte (symbol kB) is defined to equal 1,000 bytes
     *
     * Source: https://en.wikipedia.org/wiki/Byte#Multiple-byte_units
     */
    public const POWER_OF_10 = 1000;

    /**
     * Units based on powers of 2 in which 1 kibibyte (KiB) is equal to 1,024 (i.e., 2¹⁰) bytes
     *
     * Source: https://en.wikipedia.org/wiki/Byte#Multiple-byte_units
     */
    public const POWER_OF_2 = 1024;

    /**
     * Creates a new memory unit of given size
     *
     * @param  int  $bytes  [optional]
     *
     * @throws InvalidArgumentException If negative or too large bytes value provided
     */
    public function __construct(
        protected int $bytes = 0
    ) {
        if ($this->bytes < 0) {
            throw new InvalidArgumentException('Negative bytes value is not supported');
        }

        if ($this->bytes > PHP_INT_MAX) {
            throw new InvalidArgumentException('Too large bytes value');
        }
    }

    /**
     * Returns a new memory unit instance of given size
     *
     * @param  int  $bytes  [optional]
     *
     * @return static
     *
     * @throws InvalidArgumentException If negative or too large bytes value provided
     */
    public static function make(int $bytes = 0): static
    {
        return new static($bytes);
    }

    /**
     * Create a new memory unit from given string value
     *
     * Method expects string value to follow the given syntax:
     *
     * ```
     * "[value][?space][unit]"
     *
     * value = digit or float
     * space = optional whitespace character
     * unit = name or symbol of unit (case-insensitive)
     * ```
     *
     * @param  string  $value E.g. "1.32 MB", "5.12mib", "12 bytes"...etc
     *
     * @return static
     *
     * @throws InvalidArgumentException If format is invalid or unit is unknown
     */
    public static function from(string $value): static
    {
        $value = trim($value);

        if (!preg_match('/(?<value>([0-9]*[.])?[0-9]+)(?<space>\s?)(?<unit>([a-zA-Z]{1,10}))/', $value, $matches)) {
            throw new InvalidArgumentException(sprintf('Unable to parse "%s" into a valid unit', $value));
        }

        $parsedValue = (float) $matches['value'];
        $unit = strtolower($matches['unit']);

        return match($unit) {
            // byte
            'b', 'byte', 'bytes' => static::make($parsedValue),

            // kilobyte / kibibyte
            'k', 'kb', 'kilobyte', 'kilobytes' => static::fromKilobyte($parsedValue),
            'ki', 'kib', 'kibibyte', 'kibibytes' => static::fromKibibyte($parsedValue),

            // megabyte / mebibyte
            'm', 'mb', 'megabyte', 'megabytes' => static::fromMegabyte($parsedValue),
            'mi', 'mib', 'mebibyte', 'mebibytes' => static::fromMebibyte($parsedValue),

            // TODO: More to come...

            // Fail if unit is known...
            default => throw new InvalidArgumentException(sprintf('Unable to parse unit "%s" from %s', $unit, $value))
        };
    }

    /*****************************************************************
     * Operations
     ****************************************************************/

    /**
     * Returns a new memory unit instance with given value added
     *
     * @param  int|Unit  $value bytes or memory unit instance
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function add(int|Unit $value): static
    {
        if (!($value instanceof Unit)) {
            $value = static::make($value);
        }

        return static::make(
            $this->bytes() + $value->bytes()
        );
    }

    /**
     * Returns a new memory unit instance with given value subtracted
     *
     * @param  int|Unit  $value bytes or memory unit instance
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function subtract(int|Unit $value): static
    {
        if (!($value instanceof Unit)) {
            $value = static::make($value);
        }

        return static::make(
            $this->bytes() - $value->bytes()
        );
    }

    /*****************************************************************
     * Bytes
     ****************************************************************/
    
    /**
     * Returns unit's value in bytes
     * 
     * Bytes are the lowest value of memory unit.
     * 
     * @return int
     */
    public function bytes(): int
    {
        return $this->bytes;
    }

    /*****************************************************************
     * Kilobyte / Kibibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from kilobyte (power of 10)
     *
     * @param  int|float  $kilobyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromKilobyte(int|float $kilobyte): static
    {
        $bytes = round($kilobyte * static::POWER_OF_10);

        return static::make($bytes);
    }

    /**
     * Creates a new memory unit from legacy kilobyte (power of 2)
     *
     * @param  int|float  $kilobyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyKilobyte(int|float $kilobyte): static
    {
        return static::fromKibibyte($kilobyte);
    }

    /**
     * Creates a new memory unit from kibibyte (power of 2)
     *
     * @param  int|float  $kibibyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromKibibyte(int|float $kibibyte): static
    {
        $bytes = round($kibibyte * static::POWER_OF_2);

        return static::make($bytes);
    }

    /**
     * Returns unit's value in kilobyte (power of 10)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toKilobyte(int $precision = 1): float
    {
        return $this->divideBytes(static::POWER_OF_10, $precision);
    }

    /**
     * Returns unit's value in legacy kilobyte (power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toLegacyKilobyte(int $precision = 1): float
    {
        return $this->toKibibyte($precision);
    }

    /**
     * Returns unit's value in kibibyte (power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toKibibyte(int $precision = 1): float
    {
        return $this->divideBytes(static::POWER_OF_2, $precision);
    }

    /*****************************************************************
     * Megabyte / Mebibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from megabyte (power of 10)
     *
     * @param  int|float  $megabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromMegabyte(int|float $megabyte): static
    {
        $bytes = round($megabyte * pow(static::POWER_OF_10, 2));

        return static::make($bytes);
    }

    /**
     * Creates a new memory unit from legacy megabyte (power of 2)
     *
     * @param  int|float  $megabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyMegabyte(int|float $megabyte): static
    {
        return static::fromMebibyte($megabyte);
    }

    /**
     * Creates a new memory unit from mebibyte (power of 2)
     *
     * @param  int|float  $mebibyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromMebibyte(int|float $mebibyte): static
    {
        $bytes = round($mebibyte * pow(static::POWER_OF_2, 2));

        return static::make($bytes);
    }

    /**
     * Returns unit's value in megabyte (power of 10)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toMegabyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::POWER_OF_10, 2), $precision);
    }

    /**
     * Returns unit's value in legacy megabyte (power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toLegacyMegabyte(int $precision = 1): float
    {
        return $this->toMebibyte($precision);
    }

    /**
     * Returns unit's value in mebibyte (power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toMebibyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::POWER_OF_2, 2), $precision);
    }

    /*****************************************************************
     * Formatting
     ****************************************************************/

    /**
     * Format unit to human-readable string
     *
     * @param  int  $precision  [optional] Amount of decimals
     * @param  array  $units  [optional] List of symbols or units to be appended to the value
     * @param  int  $step  [optional] E.g. power of 2 (1024) or power of 10 (1000)
     *
     * @return string E.g. "14.7 MB"
     *
     * @throws InvalidArgumentException
     */
    public function format(
        int $precision = 1,
        array $units = self::UNITS_POWER_OF_10,
        int $step = self::POWER_OF_2
    ): string
    {
        // Source inspired by: https://gist.github.com/liunian/9338301
        $bytes = $this->bytes;

        // Fail when no units given
        if (empty($units)) {
            throw new InvalidArgumentException('No units provided for format bytes.');
        }

        // Fail when invalid step provided
        if ($step < 1) {
            throw new InvalidArgumentException(sprintf('Step value must be at least 1. %d provided', $step));
        }

        // Fail if negative value provided
        if ($bytes < 0) {
            throw new InvalidArgumentException('Negative bytes are not supported');
        }

        $i = 0;

        $max = count($units) - 1;
        while (($bytes / $step) > 0.99999 && $i < $max) {
            $bytes = $bytes / $step;
            $i++;
        }

        return round($bytes, $precision). ' ' . $units[$i];
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->format();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Divide unit's bytes with given value
     * 
     * @param  int|float  $value
     * @param  int  $precision  [optional]
     * 
     * @return float
     */
    protected function divideBytes(int|float $value, int $precision = 1): float
    {
        return round($this->bytes() / $value, $precision);
    }
}
