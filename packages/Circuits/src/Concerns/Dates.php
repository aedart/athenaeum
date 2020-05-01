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
    public $timezone = 'UTC';

    /**
     * Resolve given date parameter
     *
     * @param string|DateTimeInterface|null $date [optional]
     * @param string|DateTimeInterface|null $default [optional]
     *
     * @return DateTimeInterface|null
     */
    protected function resolveDate($date = null, $default = 'now'): ?DateTimeInterface
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
     * Format given date
     *
     * @param DateTimeInterface|null $date [optional]
     *
     * @return string|null Null if no date given
     */
    protected function formatDate(?DateTimeInterface $date = null): ?string
    {
        return optional($date)->format($this->dateFormat);
    }
}
