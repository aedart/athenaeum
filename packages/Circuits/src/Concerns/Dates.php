<?php

namespace Aedart\Circuits\Concerns;

use DateTimeInterface;
use DateTimeZone;
use Illuminate\Support\Facades\Date;

/**
 * Concerns Dates
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Concerns
 */
trait Dates
{
    /**
     * Date format to use
     *
     * @var string
     */
    public string $dateFormat = DateTimeInterface::RFC3339;

    /**
     * Timezone used when comparing dates
     *
     * @var DateTimeZone|string|null
     */
    public string|DateTimeZone|null $timezone = 'UTC';

    /**
     * Resolve given date parameter
     *
     * @param  DateTimeInterface|string|null  $date [optional]
     * @param  DateTimeInterface|string|null  $default [optional]
     *
     * @return DateTimeInterface|null
     */
    protected function resolveDate(
        DateTimeInterface|string|null $date = null,
        DateTimeInterface|string|null $default = 'now'
    ): DateTimeInterface|null
    {
        if ($date instanceof DateTimeInterface) {
            return $date;
        } elseif (is_string($date)) {
            return Date::make($date);
        } elseif (!isset($date) && $default === 'now') {
            return Date::now($this->timezone);
        } else {
            return Date::make($default);
        }
    }

    /**
     * Returns current date and time
     *
     * @return DateTimeInterface
     */
    protected function now(): DateTimeInterface
    {
        return Date::now($this->timezone);
    }

    /**
     * Returns a future date (current date and time + seconds into
     * the future)
     *
     * @param int $seconds
     *
     * @return DateTimeInterface
     */
    protected function futureDate(int $seconds): DateTimeInterface
    {
        return Date::now($this->timezone)->addRealSeconds($seconds);
    }

    /**
     * Format given date
     *
     * @param DateTimeInterface|null $date [optional]
     *
     * @return string|null Null if no date given
     */
    protected function formatDate(DateTimeInterface|null $date = null): string|null
    {
        return optional($date)->format($this->dateFormat);
    }
}
