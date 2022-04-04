<?php

namespace Aedart\Utils;

use Aedart\Utils\Memory\Unit;
use InvalidArgumentException;

/**
 * Memory Util
 *
 * @see \Aedart\Utils\Memory\Unit
 * @see https://en.wikipedia.org/wiki/Byte#Multiple-byte_units
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
     * Creates a new memory unit from kilobyte (decimal - power of 10)
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
     * Creates a new memory unit from legacy kilobyte (binary- power of 2)
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
     * Creates a new memory unit from kibibyte (binary- power of 2)
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
     * Creates a new memory unit from megabyte (decimal - power of 10)
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
     * Creates a new memory unit from legacy megabyte (binary - power of 2)
     *
     * @param  int|float  $megabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyMegabyte(int|float $megabyte): Unit
    {
        return Unit::fromLegacyMegabyte($megabyte);
    }

    /**
     * Creates a new memory unit from mebibyte (binary - power of 2)
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
     * Gigabyte / Gibibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from gigabyte (decimal - power of 10)
     *
     * @param  int|float  $gigabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromGigabyte(int|float $gigabyte): Unit
    {
        return Unit::fromGigabyte($gigabyte);
    }

    /**
     * Creates a new memory unit from legacy gigabyte (binary - power of 2)
     *
     * @param  int|float  $gigabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyGigabyte(int|float $gigabyte): Unit
    {
        return Unit::fromLegacyGigabyte($gigabyte);
    }

    /**
     * Creates a new memory unit from gibibyte (binary - power of 2)
     *
     * @param  int|float  $gibibyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromGibibyte(int|float $gibibyte): Unit
    {
        return Unit::fromGibibyte($gibibyte);
    }

    /*****************************************************************
     * Terabyte / Tebibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from terabyte (decimal - power of 10)
     *
     * @param  int|float  $terabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromTerabyte(int|float $terabyte): Unit
    {
        return Unit::fromTerabyte($terabyte);
    }

    /**
     * Creates a new memory unit from legacy terabyte (binary - power of 2)
     *
     * @param  int|float  $terabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyTerabyte(int|float $terabyte): Unit
    {
        return Unit::fromLegacyTerabyte($terabyte);
    }

    /**
     * Creates a new memory unit from tebibyte (binary - power of 2)
     *
     * @param  int|float  $tebibyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromTebibyte(int|float $tebibyte): Unit
    {
        return Unit::fromTebibyte($tebibyte);
    }

    /*****************************************************************
     * Petabyte / Pebibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from petabyte (decimal - power of 10)
     *
     * @param  int|float  $petabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromPetabyte(int|float $petabyte): Unit
    {
        return Unit::fromPetabyte($petabyte);
    }

    /**
     * Creates a new memory unit from pebibyte (binary - power of 2)
     *
     * @param  int|float  $pebibyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromPebibyte(int|float $pebibyte): Unit
    {
        return Unit::fromPebibyte($pebibyte);
    }

    /*****************************************************************
     * Exabyte / Exbibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from exabyte (decimal - power of 10)
     *
     * @param  int|float  $exabyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromExabyte(int|float $exabyte): Unit
    {
        return Unit::fromExabyte($exabyte);
    }

    /**
     * Creates a new memory unit from exbibyte (binary - power of 2)
     *
     * @param  int|float  $exbibyte
     *
     * @return Unit
     *
     * @throws InvalidArgumentException
     */
    public static function fromExbibyte(int|float $exbibyte): Unit
    {
        return Unit::fromExbibyte($exbibyte);
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
