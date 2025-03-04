<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Start date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\StartDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait StartDateTrait
{
    /**
     * Start date of event
     *
     * @var string|null
     */
    protected string|null $startDate = null;

    /**
     * Set start date
     *
     * @param string|null $date Start date of event
     *
     * @return self
     */
    public function setStartDate(string|null $date): static
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Get start date
     *
     * If no start date value set, method
     * sets and returns a default start date.
     *
     * @see getDefaultStartDate()
     *
     * @return string|null start date or null if no start date has been set
     */
    public function getStartDate(): string|null
    {
        if (!$this->hasStartDate()) {
            $this->setStartDate($this->getDefaultStartDate());
        }
        return $this->startDate;
    }

    /**
     * Check if start date has been set
     *
     * @return bool True if start date has been set, false if not
     */
    public function hasStartDate(): bool
    {
        return isset($this->startDate);
    }

    /**
     * Get a default start date value, if any is available
     *
     * @return string|null Default start date value or null if no default value is available
     */
    public function getDefaultStartDate(): string|null
    {
        return null;
    }
}
