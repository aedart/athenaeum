<?php

namespace Aedart\Utils\Memory;

use Countable;
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
class Unit implements
    Countable,
    Stringable
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
        //'ZB' => 'Zettabytes',
        //'YB' => 'Yottabytes'
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
        //'ZiB' => 'Zebibytes',
        //'YiB' => 'Yobibytes'
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

        return match ($unit) {
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

            // Terabyte / Tebibyte
            't', 'tb', 'terabyte', 'terabytes' => static::fromTerabyte($parsedValue),
            'ti', 'tib', 'tebibyte', 'tebibytes' => static::fromTebibyte($parsedValue),

            // Petabyte / Pebibyte
            'p', 'pb', 'petabyte', 'petabytes' => static::fromPetabyte($parsedValue),
            'pi', 'pib', 'pebibyte', 'pebibytes' => static::fromPebibyte($parsedValue),

            // Exabyte / Exbibyte
            'e', 'eb', 'exabyte', 'exabytes' => static::fromExabyte($parsedValue),
            'ei', 'eib', 'exbibyte', 'exbibytes' => static::fromExbibyte($parsedValue),

            // Fail if unit is known...
            default => throw new InvalidArgumentException(sprintf('Unable to parse unit "%s" from %s', $unit, $value))
        };
    }

    /**
     * Returns this unit's value (bytes) to the specified unit
     *
     * @param  string  $unit  [optional] Case insensitive unit, e.g. megabytes
     * @param  int  $precision  [optional]
     *
     * @return int|float
     *
     * @throws InvalidArgumentException If unit is not supported
     */
    public function to(string $unit = 'bytes', int $precision = 1): int|float
    {
        $unit = strtolower($unit);

        return match ($unit) {
            // byte
            'b', 'byte', 'bytes' => $this->bytes(),

            // kilobyte / kibibyte
            'k', 'kb', 'kilobyte', 'kilobytes' => $this->toKilobyte($precision),
            'ki', 'kib', 'kibibyte', 'kibibytes' => $this->toKibibyte($precision),

            // megabyte / mebibyte
            'm', 'mb', 'megabyte', 'megabytes' => $this->toMegabyte($precision),
            'mi', 'mib', 'mebibyte', 'mebibytes' => $this->toMebibyte($precision),

            // Gigabyte / Gibibyte
            'g', 'gb', 'gigabyte', 'gigabytes' => $this->toGigabyte($precision),
            'gi', 'gib', 'gibibyte', 'gibibytes' => $this->toGibibyte($precision),

            // Terabyte / Tebibyte
            't', 'tb', 'terabyte', 'terabytes' => $this->toTerabyte($precision),
            'ti', 'tib', 'tebibyte', 'tebibytes' => $this->toTebibyte($precision),

            // Petabyte / Pebibyte
            'p', 'pb', 'petabyte', 'petabytes' => $this->toPetabyte($precision),
            'pi', 'pib', 'pebibyte', 'pebibytes' => $this->toPebibyte($precision),

            // Exabyte / Exbibyte
            'e', 'eb', 'exabyte', 'exabytes' => $this->toExabyte($precision),
            'ei', 'eib', 'exbibyte', 'exbibytes' => $this->toExbibyte($precision),

            // Fail if unit is known...
            default => throw new InvalidArgumentException(sprintf('Unsupported "%s" unit. Cannot convert %s bytes to "%s"', $unit, $this->bytes(), $unit))
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
     * Creates a new memory unit from kilobyte (decimal - power of 10)
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
     * Creates a new memory unit from legacy kilobyte (binary - power of 2)
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
     * Creates a new memory unit from kibibyte (binary - power of 2)
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
     * Returns unit's value in kilobyte (decimal - power of 10)
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
     * Returns unit's value in legacy kilobyte (binary - power of 2)
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
     * Returns unit's value in kibibyte (binary - power of 2)
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
     * Creates a new memory unit from megabyte (decimal - power of 10)
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
     * Creates a new memory unit from legacy megabyte (binary - power of 2)
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
     * Returns unit's value in megabyte (decimal - power of 10)
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
     * Returns unit's value in legacy megabyte (binary - power of 2)
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
     * Returns unit's value in mebibyte (binary - power of 2)
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
     * Creates a new memory unit from gigabyte (decimal - power of 10)
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
     * Creates a new memory unit from legacy gigabyte (binary - power of 2)
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
     * Creates a new memory unit from gibibyte (binary - power of 2)
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
     * Returns unit's value in gigabyte (decimal - power of 10)
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
     * Returns unit's value in legacy gigabyte (binary - power of 2)
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
     * Returns unit's value in gibibyte (binary - power of 2)
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
     * Terabyte / Tebibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from terabyte (decimal - power of 10)
     *
     * @param  int|float  $terabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromTerabyte(int|float $terabyte): static
    {
        $bytes = round($terabyte * pow(static::DECIMAL_VALUE, 4));

        return static::make($bytes);
    }

    /**
     * Creates a new memory unit from legacy terabyte (binary - power of 2)
     *
     * @param  int|float  $terabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromLegacyTerabyte(int|float $terabyte): static
    {
        return static::fromTebibyte($terabyte);
    }

    /**
     * Creates a new memory unit from tebibyte (binary - power of 2)
     *
     * @param  int|float  $tebibyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromTebibyte(int|float $tebibyte): static
    {
        $bytes = round($tebibyte * pow(static::BINARY_VALUE, 4));

        return static::make($bytes);
    }

    /**
     * Returns unit's value in terabyte (decimal - power of 10)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toTerabyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::DECIMAL_VALUE, 4), $precision);
    }

    /**
     * Returns unit's value in legacy terabyte (binary - power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toLegacyTerabyte(int $precision = 1): float
    {
        return $this->toTebibyte($precision);
    }

    /**
     * Returns unit's value in tebibyte (binary - power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toTebibyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::BINARY_VALUE, 4), $precision);
    }

    /*****************************************************************
     * Petabyte / Pebibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from petabyte (decimal - power of 10)
     *
     * @param  int|float  $petabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromPetabyte(int|float $petabyte): static
    {
        $bytes = round($petabyte * pow(static::DECIMAL_VALUE, 5));

        return static::make($bytes);
    }

    /**
     * Creates a new memory unit from pebibyte (binary - power of 2)
     *
     * @param  int|float  $pebibyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromPebibyte(int|float $pebibyte): static
    {
        $bytes = round($pebibyte * pow(static::BINARY_VALUE, 5));

        return static::make($bytes);
    }

    /**
     * Returns unit's value in petabyte (decimal - power of 10)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toPetabyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::DECIMAL_VALUE, 5), $precision);
    }

    /**
     * Returns unit's value in pebibyte (binary - power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toPebibyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::BINARY_VALUE, 5), $precision);
    }

    /*****************************************************************
     * Exabyte / Exbibyte
     ****************************************************************/

    /**
     * Creates a new memory unit from exabyte (decimal - power of 10)
     *
     * @param  int|float  $exabyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromExabyte(int|float $exabyte): static
    {
        $bytes = round($exabyte * pow(static::DECIMAL_VALUE, 6));

        return static::make($bytes);
    }

    /**
     * Creates a new memory unit from exbibyte (binary - power of 2)
     *
     * @param  int|float  $exbibyte
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function fromExbibyte(int|float $exbibyte): static
    {
        $bytes = round($exbibyte * pow(static::BINARY_VALUE, 6));

        return static::make($bytes);
    }

    /**
     * Returns unit's value in exabyte (decimal - power of 10)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toExabyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::DECIMAL_VALUE, 6), $precision);
    }

    /**
     * Returns unit's value in exbibyte (binary - power of 2)
     *
     * @param  int  $precision  [optional]
     *
     * @return float
     */
    public function toExbibyte(int $precision = 1): float
    {
        return $this->divideBytes(pow(static::BINARY_VALUE, 6), $precision);
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
    ): string {
        // Source inspired by: https://gist.github.com/liunian/9338301
        $bytes = $this->bytes;

        // Fail when no units given
        if (empty($units)) {
            throw new InvalidArgumentException('No units provided for format bytes.');
        }

        // Obtain symbols, if short format requested.
        if ($short) {
            $units = array_keys($units);
        } else {
            // Otherwise, use the full unit name...
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

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->bytes();
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
