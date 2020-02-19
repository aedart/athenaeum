<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Calendar Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CalendarAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CalendarTrait
{
    /**
     * Location to calendar, e.g. URI, name, ID or other identifier
     *
     * @var string|null
     */
    protected ?string $calendar = null;

    /**
     * Set calendar
     *
     * @param string|null $location Location to calendar, e.g. URI, name, ID or other identifier
     *
     * @return self
     */
    public function setCalendar(?string $location)
    {
        $this->calendar = $location;

        return $this;
    }

    /**
     * Get calendar
     *
     * If no "calendar" value set, method
     * sets and returns a default "calendar".
     *
     * @see getDefaultCalendar()
     *
     * @return string|null calendar or null if no calendar has been set
     */
    public function getCalendar(): ?string
    {
        if (!$this->hasCalendar()) {
            $this->setCalendar($this->getDefaultCalendar());
        }
        return $this->calendar;
    }

    /**
     * Check if "calendar" has been set
     *
     * @return bool True if "calendar" has been set, false if not
     */
    public function hasCalendar(): bool
    {
        return isset($this->calendar);
    }

    /**
     * Get a default "calendar" value, if any is available
     *
     * @return string|null Default "calendar" value or null if no default value is available
     */
    public function getDefaultCalendar(): ?string
    {
        return null;
    }
}
