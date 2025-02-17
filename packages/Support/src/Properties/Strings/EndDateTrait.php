<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * End date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\EndDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait EndDateTrait
{
    /**
     * Date for when some kind of event ends
     *
     * @var string|null
     */
    protected string|null $endDate = null;

    /**
     * Set end date
     *
     * @param string|null $date Date for when some kind of event ends
     *
     * @return self
     */
    public function setEndDate(string|null $date): static
    {
        $this->endDate = $date;

        return $this;
    }

    /**
     * Get end date
     *
     * If no end date value set, method
     * sets and returns a default end date.
     *
     * @see getDefaultEndDate()
     *
     * @return string|null end date or null if no end date has been set
     */
    public function getEndDate(): string|null
    {
        if (!$this->hasEndDate()) {
            $this->setEndDate($this->getDefaultEndDate());
        }
        return $this->endDate;
    }

    /**
     * Check if end date has been set
     *
     * @return bool True if end date has been set, false if not
     */
    public function hasEndDate(): bool
    {
        return isset($this->endDate);
    }

    /**
     * Get a default end date value, if any is available
     *
     * @return string|null Default end date value or null if no default value is available
     */
    public function getDefaultEndDate(): string|null
    {
        return null;
    }
}
