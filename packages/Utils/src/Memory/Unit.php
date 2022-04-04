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
     * Default decimal units (powers of 10)
     *
     * Key = symbol, value = unit name (plural)
     *
     * Source: https://en.wikipedia.org/wiki/Byte
     */
    public const DECIMAL_UNITS = [
        'B' => 'Bytes',
        'kB' => 'Kilobytes',
        'MB' => 'Megabytes',
        'GB' => 'Gigabytes',
        'TB' => 'Terabytes',
        'PB' => 'Petabytes',
        'EB' => 'Exabytes',
        'ZB' => 'Zettabytes',
        'YB' => 'Yottabytes'
    ];

    /**
     * Default binary units (powers of 2)
     *
     * Key = symbol, value = unit name (plural)
     *
     * Source: https://en.wikipedia.org/wiki/Byte
     */
    public const BINARY_UNITS = [
        'B' => 'Bytes',
        'KiB' => 'Kibibytes',
        'MiB' => 'Mebibytes',
        'GiB' => 'Gibibytes',
        'TiB' => 'Tebibytes',
        'PiB' => 'Pebibytes',
        'EiB' => 'Exbibytes',
        'ZiB' => 'Zebibytes',
        'YiB' => 'Yobibytes'
    ];

    /**
     * Value based on powers of 10, in which 1 kilobyte (kB) is defined to equal 1,000 bytes
     *
     * Source: https://en.wikipedia.org/wiki/Byte#Multiple-byte_units
     */
    public const DECIMAL_VALUE = 1000;

    /**
     * Value based on powers of 2 in which 1 kibibyte (KiB) is equal to 1024 bytes
     *
     * Source: https://en.wikipedia.org/wiki/Byte#Multiple-byte_units
     */
    public const BINARY_VALUE = 1024;

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

            // Gigabyte / Gibibyte
            'g', 'gb', 'gigabyte', 'gigabytes' => static::fromGigabyte($parsedValue),
            'gi', 'gib', 'gibibyte', 'gibibytes' => static::fromGibibyte($parsedValue),

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
        $bytes = round($kilobyte * static::DECIMAL_VALUE);

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
        $bytes = round($kibibyte * static::BINARY_VALUE);

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
        return $this->divideBytes(static::DECIMAL_VALUE, $precision);
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
        return $this->divideBytes(static::BINARY_VALUE, $precision);
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
        $bytes = round($megabyte * pow(static::DECIMAL_VALUE, 2));

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
        $bytes = round($mebibyte * pow(static::BINARY_VALUE, 2));

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
        return $this->divideBytes(pow(static::DECIMAL_VALUE, 2), $precision);
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
        return $this->divideBytes(pow(static::BINARY_VALUE, 2), $precision);
    }

    /*****************************************************************
     * Gigabyte / Gibibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from gigabyte (power of 10)
     *
     * @param  int|float  $gigabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromGigabyte(int|float $gigabyte): static
    {
        $bytes = round($gigabyte * pow(static::DECIMAL_VALUE, 3));

        return static::make($bytes);
    }

    /**
     * Creates a new memory unit from legacy gigabyte (power of 2)
     *
     * @param  int|float  $gigabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyGigabyte(int|float $gigabyte): static
    {
        return static::fromGibibyte($gigabyte);
    }

    /**
     * Creates a new memory unit from gibibyte (power of 2)
     *
     * @param  int|float  $gibibyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromGibibyte(int|float $gibibyte): static
    {
        $bytes = round($gibibyte * pow(static::BINARY_VALUE, 3));

        return static::make($bytes);
    }

    /**
     * Returns unit's value in gigabyte (power of 10)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toGigabyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::DECIMAL_VALUE, 3), $precision);
    }

    /**
     * Returns unit's value in legacy gigabyte (power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toLegacyGigabyte(int $precision = 1): float
    {
        return $this->toGibibyte($precision);
    }

    /**
     * Returns unit's value in gibibyte (power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toGibibyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::BINARY_VALUE, 3), $precision);
    }

    /*****************************************************************
     * Formatting
     ****************************************************************/

    /**
     * Format unit to human-readable string, using the binary units as order of magnitude
     *
     * @see https://en.wikipedia.org/wiki/Orders_of_magnitude_(data)
     *
     * @param  int  $precision  [optional] Amount of decimals
     * @param  bool  $short  [optional] If true, then a symbol are affixed the formatted value
     *
     * @return string E.g. "14.7 MiB"
     *
     * @throws InvalidArgumentException
     */
    public function binaryFormat(int $precision = 1, bool $short = true): string
    {
        return $this->format($precision, $short, self::BINARY_UNITS, self::BINARY_VALUE);
    }

    /**
     * Format unit to human-readable string, using the decimal units as order of magnitude
     *
     * @see https://en.wikipedia.org/wiki/Orders_of_magnitude_(data)
     *
     * @param  int  $precision  [optional] Amount of decimals
     * @param  bool  $short  [optional] If true, then a symbol are affixed the formatted value
     *
     * @return string E.g. "14.7 MB"
     *
     * @throws InvalidArgumentException
     */
    public function decimalFormat(int $precision = 1, bool $short = true): string
    {
        return $this->format($precision, $short, self::DECIMAL_UNITS, self::DECIMAL_VALUE);
    }

    /**
     * Format unit to human-readable string, using the legacy units as order of magnitude
     *
     * @param  int  $precision  [optional] Amount of decimals
     * @param  bool  $short  [optional] If true, then a symbol are affixed the formatted value
     *
     * @return string E.g. "14.7 MB"
     *
     * @throws InvalidArgumentException
     */
    public function legacyFormat(int $precision = 1, bool $short = true): string
    {
        return $this->format($precision, $short, self::DECIMAL_UNITS, self::BINARY_VALUE);
    }

    /**
     * Format unit to human-readable string
     *
     * @param  int  $precision  [optional] Amount of decimals
     * @param  bool  $short  [optional] If true, then a symbol are affixed the formatted value
     * @param  array  $units  [optional] List of symbols and units names to be appended to the value. Key = symbol, value = unit name
     * @param  int  $step  [optional] E.g. binary value (power of 2: 1 KiB = 1024 bytes) or decimal value (power of 10: 1 KB  = 1000 bytes)
     *
     * @return string E.g. "14.7 MB"
     *
     * @throws InvalidArgumentException
     */
    public function format(
        int $precision = 1,
        bool $short = true,
        array $units = self::BINARY_UNITS,
        int $step = self::BINARY_VALUE
    ): string
    {
        // Source inspired by: https://gist.github.com/liunian/9338301
        $bytes = $this->bytes;

        // Fail when no units given
        if (empty($units)) {
            throw new InvalidArgumentException('No units provided for format bytes.');
        }

        // Obtain symbols, if short format requested
        if ($short) {
            $units = array_keys($units);
        } else {
            $units = array_values($units);
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
