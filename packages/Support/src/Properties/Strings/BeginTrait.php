<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Begin Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\BeginAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait BeginTrait
{
    /**
     * Location, index or some other identifier of where something begins
     *
     * @var string|null
     */
    protected string|null $begin = null;

    /**
     * Set begin
     *
     * @param string|null $location Location, index or some other identifier of where something begins
     *
     * @return self
     */
    public function setBegin(string|null $location): static
    {
        $this->begin = $location;

        return $this;
    }

    /**
     * Get begin
     *
     * If no begin value set, method
     * sets and returns a default begin.
     *
     * @see getDefaultBegin()
     *
     * @return string|null begin or null if no begin has been set
     */
    public function getBegin(): string|null
    {
        if (!$this->hasBegin()) {
            $this->setBegin($this->getDefaultBegin());
        }
        return $this->begin;
    }

    /**
     * Check if begin has been set
     *
     * @return bool True if begin has been set, false if not
     */
    public function hasBegin(): bool
    {
        return isset($this->begin);
    }

    /**
     * Get a default begin value, if any is available
     *
     * @return string|null Default begin value or null if no default value is available
     */
    public function getDefaultBegin(): string|null
    {
        return null;
    }
}
