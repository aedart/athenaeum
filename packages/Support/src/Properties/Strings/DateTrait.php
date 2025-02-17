<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DateTrait
{
    /**
     * Date of event
     *
     * @var string|null
     */
    protected string|null $date = null;

    /**
     * Set date
     *
     * @param string|null $date Date of event
     *
     * @return self
     */
    public function setDate(string|null $date): static
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
     * @return string|null date or null if no date has been set
     */
    public function getDate(): string|null
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
     * @return string|null Default date value or null if no default value is available
     */
    public function getDefaultDate(): string|null
    {
        return null;
    }
}
