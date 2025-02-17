<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Pattern Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PatternAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PatternTrait
{
    /**
     * Some kind of a pattern, e.g. search or regex
     *
     * @var string|null
     */
    protected string|null $pattern = null;

    /**
     * Set pattern
     *
     * @param string|null $pattern Some kind of a pattern, e.g. search or regex
     *
     * @return self
     */
    public function setPattern(string|null $pattern): static
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Get pattern
     *
     * If no pattern value set, method
     * sets and returns a default pattern.
     *
     * @see getDefaultPattern()
     *
     * @return string|null pattern or null if no pattern has been set
     */
    public function getPattern(): string|null
    {
        if (!$this->hasPattern()) {
            $this->setPattern($this->getDefaultPattern());
        }
        return $this->pattern;
    }

    /**
     * Check if pattern has been set
     *
     * @return bool True if pattern has been set, false if not
     */
    public function hasPattern(): bool
    {
        return isset($this->pattern);
    }

    /**
     * Get a default pattern value, if any is available
     *
     * @return string|null Default pattern value or null if no default value is available
     */
    public function getDefaultPattern(): string|null
    {
        return null;
    }
}
