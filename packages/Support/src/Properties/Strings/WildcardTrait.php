<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Wildcard Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\WildcardAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait WildcardTrait
{
    /**
     * Wildcard identifier
     *
     * @var string|null
     */
    protected ?string $wildcard = null;

    /**
     * Set wildcard
     *
     * @param string|null $identifier Wildcard identifier
     *
     * @return self
     */
    public function setWildcard(?string $identifier)
    {
        $this->wildcard = $identifier;

        return $this;
    }

    /**
     * Get wildcard
     *
     * If no "wildcard" value set, method
     * sets and returns a default "wildcard".
     *
     * @see getDefaultWildcard()
     *
     * @return string|null wildcard or null if no wildcard has been set
     */
    public function getWildcard(): ?string
    {
        if (!$this->hasWildcard()) {
            $this->setWildcard($this->getDefaultWildcard());
        }
        return $this->wildcard;
    }

    /**
     * Check if "wildcard" has been set
     *
     * @return bool True if "wildcard" has been set, false if not
     */
    public function hasWildcard(): bool
    {
        return isset($this->wildcard);
    }

    /**
     * Get a default "wildcard" value, if any is available
     *
     * @return string|null Default "wildcard" value or null if no default value is available
     */
    public function getDefaultWildcard(): ?string
    {
        return null;
    }
}
