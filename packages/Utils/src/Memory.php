<?php

namespace Aedart\Utils;

use Aedart\Utils\Memory\Unit;
use InvalidArgumentException;

/**
 * Memory Util
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Memory
{
    /**
     * Creates a new memory unit instance
     *
     * @param  int  $bytes  [optional]
     *
     * @return Unit
     *
     * @throws InvalidArgumentException If negative or too large bytes value provided
     */
    public static function unit(int $bytes = 0): Unit
    {
        return Unit::make($bytes);
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
     * @return Unit
     *
     * @throws InvalidArgumentException If format is invalid or unit is unknown
     */
    public static function from(string $value): Unit
    {
        return Unit::from($value);
    }

    /*****************************************************************
     * Kilobyte / Kibibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from kilobyte (power of 10)
     *
     * @param  int|float  $kilobyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromKilobyte(int|float $kilobyte): Unit
    {
        return Unit::fromKilobyte($kilobyte);
    }

    /**
     * Creates a new memory unit from legacy kilobyte (power of 2)
     *
     * @param  int|float  $kilobyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyKilobyte(int|float $kilobyte): Unit
    {
        return Unit::fromLegacyKilobyte($kilobyte);
    }

    /**
     * Creates a new memory unit from kibibyte (power of 2)
     *
     * @param  int|float  $kibibyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromKibibyte(int|float $kibibyte): Unit
    {
        return Unit::fromKibibyte($kibibyte);
    }

    /*****************************************************************
     * Megabyte / Mebibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from megabyte (power of 10)
     *
     * @param  int|float  $megabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromMegabyte(int|float $megabyte): Unit
    {
        return Unit::fromMegabyte($megabyte);
    }

    /**
     * Creates a new memory unit from legacy megabyte (power of 2)
     *
     * @param  int|float  $kilobyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyMegabyte(int|float $kilobyte): Unit
    {
        return Unit::fromLegacyMegabyte($kilobyte);
    }

    /**
     * Creates a new memory unit from mebibyte (power of 2)
     *
     * @param  int|float  $mebibyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromMebibyte(int|float $mebibyte): Unit
    {
        return Unit::fromMebibyte($mebibyte);
    }

    /*****************************************************************
     * Formatting
     ****************************************************************/

    /**
     * Format bytes to human-readable string
     *
     * @param  int  $bytes
     * @param  int  $precision  [optional] Amount of decimals
     * @param  bool  $short  [optional] If true, then a symbol are affixed the formatted value
     * @param  array  $units  [optional] List of symbols and units names to be appended to the value. Key = symbol, value = unit name
     * @param  int  $step  [optional] E.g. binary value (power of 2: 1 KiB = 1024 bytes) or decimal value (power of 10: 1 KB  = 1000 bytes)
     *
     * @return string E.g. "14.7 MB"
     *
     * @throws InvalidArgumentException
     */
    public static function format(
        int $bytes,
        int $precision = 1,
        bool $short = true,
        array $units = Unit::BINARY_UNITS,
        int $step = Unit::BINARY_VALUE
    ): string
    {
        return static::unit($bytes)->format($precision, $short, $units, $step);
    }
}
