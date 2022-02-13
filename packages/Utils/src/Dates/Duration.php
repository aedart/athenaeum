<?php

namespace Aedart\Utils\Dates;

use DateInterval;
use DateTime;
use Stringable;

/**
 * Duration class to handle time intervals with microsecond precision.
 *
 * Needed because DateInterval has some not so funny quirks.
 *
 * @author steffen
 * @package Aedart\Utils\Dates
 */
class Duration implements Stringable
{
    /**
     * Micro Timestamp instance
     *
     * @var MicroTimeStamp
     */
    protected MicroTimeStamp $microTimeStamp;

    /**
     * Constructor that can take a DateTime, a DateInterval, a MicroTimeStamp or integer seconds
     *
     * @param  DateInterval|DateTime|int|MicroTimeStamp|null  $time  [optional]
     */
    public function __construct(DateInterval|DateTime|MicroTimeStamp|int|null $time = null)
    {
        if ($time instanceof DateTime) {
            $this->microTimeStamp = MicroTimeStamp::fromDateTime($time);
        } elseif ($time instanceof DateInterval) {
            $this->microTimeStamp = MicroTimeStamp::fromDateInterval($time);
        } elseif ($time instanceof MicroTimeStamp) {
            $this->microTimeStamp = $time;
        } elseif (is_integer($time)) {
            $this->microTimeStamp = MicroTimeStamp::fromSeconds($time);
        }
    }

    /**
     * Create instance from either a DateTime, a DateInterval, a MicroTimeStamp or integer seconds
     *
     * @param  DateTime|DateInterval|MicroTimeStamp|int  $interval
     *
     * @return static
     */
    public static function from(DateTime|DateInterval|MicroTimeStamp|int $interval): static
    {
        return new static($interval);
    }

    /**
     * Create instance from time string.
     *
     * @param  string  $timeStr
     *
     * @return static
     */
    public static function fromString(string $timeStr): static
    {
        return new static(strtotime($timeStr));
    }

    /**
     * Create instance from integer seconds
     *
     * @param  int  $seconds
     *
     * @return static
     */
    public static function fromSeconds(int $seconds): static
    {
        return new static($seconds);
    }

    /**
     * Create instance from integer minutes and optional microseconds.
     *
     * @param  int  $minutes
     * @param  int  $microSeconds  [optional]
     *
     * @return static
     */
    public static function fromMinutes(int $minutes, int $microSeconds = 0): static
    {
        return new static(new MicroTimeStamp($minutes, $microSeconds));
    }

    /**
     * Create instance from integer hours and optional minutes
     *
     * @param  int  $hours
     * @param  int  $minutes  [optional]
     * @return static
     */
    public static function fromHoursMinutes(int $hours, int $minutes = 0): static
    {
        // Convert minutes to negative minutes, in case negative hours
        // are provided.
        if ($hours < 0) {
            $minutes *= -1;
        }

        $totalMinutes = ($hours * 60) + $minutes;

        return static::fromMinutes($totalMinutes);
    }

    /**
     * Create instance from string hours and minutes
     *
     * @param  string  $hoursMinutes E.g. 00:30, 1:56, -2:30... etc
     * @param  string  $separator  [optional] Hours / minutes separator symbol
     *
     * @return static
     */
    public static function fromStringHoursMinutes(string $hoursMinutes, string $separator = ':'): static
    {
        list($hours, $minutes) = explode($separator, $hoursMinutes);

        return static::fromHoursMinutes($hours, $minutes);
    }

    /**
     * Create instance from difference of two DateTime objects.
     *
     * @param  DateTime  $start
     * @param  DateTime  $stop
     * @return static
     */
    public static function fromDifference(DateTime $start, DateTime $stop): static
    {
        return new static($start->diff($stop));
    }

    /**
     * Start timer
     */
    public function start(): void
    {
        $this->microTimeStamp = MicroTimeStamp::fromDateTime(new DateTime());
    }

    /**
     * Stop timer
     */
    public function stop(): void
    {
        $stop = MicroTimeStamp::fromDateTime(new DateTime());

        $this->microTimeStamp = MicroTimeStamp::fromSecondsFloat($stop->getAsSecondsFloat() - $this->microTimeStamp->getAsSecondsFloat());
    }

    /**
     * Add another Duration to this.
     *
     * @param  Duration  $duration
     *
     * @return self
     */
    public function add(Duration $duration): static
    {
        $this->microTimeStamp = MicroTimeStamp::fromSecondsFloat($this->microTimeStamp->getAsSecondsFloat() + $duration->asFloatSeconds());

        return $this;
    }

    /**
     * Subtract another Duration from this.
     *
     * @param  Duration  $duration
     *
     * @return self
     */
    public function subtract(Duration $duration): static
    {
        $this->microTimeStamp = MicroTimeStamp::fromSecondsFloat($this->microTimeStamp->getAsSecondsFloat() - $duration->asFloatSeconds());

        return $this;
    }

    /**
     * Return duration as integer seconds.
     *
     * @return int
     */
    public function asSeconds(): int
    {
        return $this->microTimeStamp->getAsSeconds();
    }

    /**
     * Return duration as decimal seconds.
     *
     * @return float
     */
    public function asFloatSeconds(): float
    {
        return $this->microTimeStamp->getAsSecondsFloat();
    }

    /**
     * Return duration as integer minutes.
     *
     * @return int
     */
    public function asMinutes(): int
    {
        return intval($this->microTimeStamp->getAsSeconds() / 60);
    }

    /**
     * Same as \DateInterval::format().
     *
     * @see DateInterval::format()
     *
     * @param  string  $format
     *
     * @return string
     */
    public function format(string $format): string
    {
        return $this->microTimeStamp->getAsDateInterval()->format($format);
    }

    /**
     * Format duration as minutes and seconds
     *
     * NOTE: Method will show value above 60 minutes, if initial
     * duration surpasses such.
     *
     * @param  bool  $long  [optional]
     * @return string
     */
    public function toMinutesSeconds(bool $long = false): string
    {
        $format = $long
            ? '%s%02d minutes %02u seconds'
            : '%s%02d:%02u';
        $prefix = '';

        $duration = $this->microTimeStamp->getAsSeconds();

        // Convert to minutes and seconds, using absolute seconds
        $minutes = intval(floor(abs($duration) / 60));
        $seconds = intval(floor(abs($duration) % 60));

        // Convert to negative minutes, if negative seconds given.
        if ($duration < 0 && $minutes === 0) {
            $prefix = '-';
        } elseif ($duration < 0) {
            $minutes *= -1;
        }

        return sprintf($format, $prefix, $minutes, $seconds);
    }

    /**
     * Format duration as hours and minutes.
     *
     * NOTE: Method will show value above 24 hours, if initial
     * duration surpasses such.
     *
     * @param  bool  $long  [optional]
     *
     * @return string
     */
    public function toHoursMinutes(bool $long = false): string
    {
        $format = $long
            ? '%s%d hours %u minutes'
            : '%s%02d:%02u';
        $prefix = '';

        $seconds = $this->microTimeStamp->getAsSeconds();

        // Convert to hours and minutes, using absolute seconds
        $hours = intval(floor(abs($seconds) / 3600));
        $minutes = intval(floor((abs($seconds) / 60) % 60));

        // Convert to negative hours, if negative seconds given.
        // NOTE: Edge case, when 0 hours then we use a prefix symbol.
        if ($seconds < 0 && $hours === 0) {
            $prefix = '-';
        } elseif ($seconds < 0) {
            $hours *= -1;
        }

        return sprintf($format, $prefix, $hours, $minutes);
    }

    /**
     * Format duration as days, hours and minutes.
     *
     * @param  bool  $long  [optional]
     *
     * @return string
     */
    public function toDaysHoursMinutes(bool $long = false): string
    {
        $format = $long
            ? '%d days %d hours %u minutes'
            : '%d-%02u:%02u';

        $seconds = $this->microTimeStamp->getAsSeconds();
        $days = intval($seconds / (24 * 3600));
        $hours = intval((abs($seconds) % (24 * 3600)) / 3600);
        $minutes = intval((abs($seconds) % (60 * 60)) / 60);

        return sprintf($format, $days, $hours, $minutes);
    }

    /**
     * Format duration to a string.
     * Shortest text according to duration length.
     *
     * @param  bool  $long  [optional]
     *
     * @return string
     */
    public function toString(bool $long = false): string
    {
        $seconds = $this->microTimeStamp->getAsSeconds();
        if ($seconds > 24 * 3600) {
            return $this->toDaysHoursMinutes($long);
        } elseif ($seconds > 3600) {
            return $this->toHoursMinutes($long);
        }
        return $this->toMinutesSeconds($long);
    }

    /**
     * Returns string representation of this duration
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString(true);
    }
}
