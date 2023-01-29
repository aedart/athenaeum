<?php

namespace Aedart\Utils\Dates;

use DateInterval;
use DateTimeInterface;

/**
 * TimeStamp with microseconds resolution.
 *
 * Can hold very large values, but with some limitations:
 * - Years are always 365 days.
 * - Months are always 30 days.
 *
 * @author steffen
 * @package Aedart\Utils\Dates
 */
class MicroTimeStamp
{
    /**
     * Constructor that can populate the timestamp
     *
     * @param  int  $minutes [optional]
     * @param  int  $microSeconds [optional]
     */
    public function __construct(
        protected int $minutes = 0,
        protected int $microSeconds = 0
    ) {
    }

    /**
     * Factory to create from seconds and optional microseconds
     *
     * @param  int  $seconds
     * @param  int  $microSeconds [optional]
     *
     * @return static
     */
    public static function fromSeconds(int $seconds, int $microSeconds = 0): static
    {
        return new static($seconds / 60, (($seconds % 60) * 1000000) + $microSeconds);
    }

    /**
     * Factory to create from a DateTime object.
     * Time is relative to Unix epoch.
     *
     * @param  DateTimeInterface  $dt
     *
     * @return static
     */
    public static function fromDateTime(DateTimeInterface $dt): static
    {
        [$seconds, $microSeconds] = explode(' ', $dt->format('U u'));

        return static::fromSeconds($seconds, $microSeconds);
    }

    /**
     * Factory to create from DateInterval.
     * Only support intervals up to day field.
     *
     * @param  DateInterval  $dt
     *
     * @return static
     */
    public static function fromDateInterval(DateInterval $dt): static
    {
        $minutes = ($dt->y * 365 * 24 * 60) + ($dt->m * 30 * 24 * 60) + ($dt->d * 24 * 60) + ($dt->h * 60) + $dt->i + intval($dt->s / 60);
        $microSeconds = intval((($dt->s % 60) + $dt->f) * 1000000);

        if ($dt->invert) {
            $minutes *= -1;
            $microSeconds *= -1;
        }

        return new static($minutes, $microSeconds);
    }

    /**
     * Factory to create from seconds with fractions.
     *
     * @param  float  $seconds
     *
     * @return static
     */
    public static function fromSecondsFloat(float $seconds): static
    {
        $minutes = intval($seconds / 60);
        $microSeconds = intval(($seconds * 1000000) % 60000000);

        return new static($minutes, $microSeconds);
    }

    /**
     * Get the actual minutes content.
     *
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->minutes;
    }

    /**
     * Get the actual microseconds content.
     *
     * @return int
     */
    public function getMicroSeconds(): int
    {
        return $this->microSeconds;
    }

    /**
     * Get as integer seconds.
     *
     * @return int
     */
    public function getAsSeconds(): int
    {
        return ($this->minutes * 60) + intval($this->microSeconds / 1000000);
    }

    /**
     * Get as float seconds.
     *
     * @return float
     */
    public function getAsSecondsFloat(): float
    {
        return ($this->minutes * 60) + ($this->microSeconds / 1000000);
    }

    /**
     * Get a correctly populated DateInterval.
     *
     * @return DateInterval
     */
    public function getAsDateInterval(): DateInterval
    {
        $minutes = abs($this->minutes);
        $microSeconds = abs($this->microSeconds);

        $dt = new DateInterval('PT0S');
        $dt->y = intval($minutes / (365 * 24 * 60));
        $minutes %= (365 * 24 * 60);

        $dt->m = intval($minutes / (30 * 24 * 60));
        $minutes %= (30 * 24 * 60);

        $dt->d = intval($minutes / (24 * 60));
        $minutes %= 24 * 60;

        $dt->h = intval($minutes / 60);
        $minutes %= 60;

        $dt->i = $minutes;

        $dt->s = intval($microSeconds / 1000000);
        $microSeconds %= 1000000;

        $dt->f = $microSeconds / 1000000;

        if ($this->minutes < 0 || $this->microSeconds < 0) {
            $dt->invert = 1;
        }

        return $dt;
    }
}
