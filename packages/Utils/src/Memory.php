<?php

namespace Aedart\Utils;

use InvalidArgumentException;
use OutOfRangeException;

/**
 * Memory Util
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Memory
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
     * Format bytes to human-readable string
     *
     * @param  int|float  $bytes
     * @param  int  $precision  [optional] Amount of decimals
     * @param  array  $units  [optional] List of symbols or units to be appended to the value
     * @param  int  $step  [optional] E.g. power of 2 (1024) or power of 10 (1000)
     *
     * @return string E.g. "14.7 MB"
     *
     * @throws InvalidArgumentException
     */
    public static function format(
        int|float $bytes,
        int $precision = 1,
        array $units = self::UNITS_POWER_OF_10,
        int $step = self::POWER_OF_2
    ): string
    {
        // Source inspired by: https://gist.github.com/liunian/9338301

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
}
