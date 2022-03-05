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
     * Format bytes to human-readable string
     *
     * @param  int|float  $bytes
     * @param  int  $precision  [optional]
     * @param  array  $units  [optional]
     *
     * @return string
     *
     * @throws InvalidArgumentException When no units given
     */
    public static function format(
        int|float $bytes,
        int $precision = 2,
        array $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
    ): string
    {
        // Source inspired by: https://gist.github.com/liunian/9338301

        // Fail when no units given
        if (empty($units)) {
            throw new InvalidArgumentException('No units provided for format bytes.');
        }

        // Fail if negative value provided
        if ($bytes < 0) {
            throw new InvalidArgumentException('Negative bytes are not supported');
        }

        static $step = 1024;
        $i = 0;

        $max = count($units) - 1;
        while (($bytes / $step) > 0.9 && $i < $max) {
            $bytes = $bytes / $step;
            $i++;
        }

        return round($bytes, $precision). ' ' . $units[$i];
    }
}
