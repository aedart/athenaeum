<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\DateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait DateTrait
{
    /**
     * Date of event
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $date = null;

    /**
     * Set date
     *
     * @param \DateTimeInterface|null $date Date of event
     *
     * @return self
     */
    public function setDate(\DateTimeInterface|null $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * If no date value set, method
     * sets and returns a default date.
     *
     * @see getDefaultDate()
     *
     * @return \DateTimeInterface|null date or null if no date has been set
     */
    public function getDate(): \DateTimeInterface|null
    {
        if (!$this->hasDate()) {
            $this->setDate($this->getDefaultDate());
        }
        return $this->date;
    }

    /**
     * Check if date has been set
     *
     * @return bool True if date has been set, false if not
     */
    public function hasDate(): bool
    {
        return isset($this->date);
    }

    /**
     * Get a default date value, if any is available
     *
     * @return \DateTimeInterface|null Default date value or null if no default value is available
     */
    public function getDefaultDate(): \DateTimeInterface|null
    {
        return null;
    }
}
