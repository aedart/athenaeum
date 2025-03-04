<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Tld Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TldAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TldTrait
{
    /**
     * Top Level Domain (TLD)
     *
     * @var string|null
     */
    protected string|null $tld = null;

    /**
     * Set tld
     *
     * @param string|null $tld Top Level Domain (TLD)
     *
     * @return self
     */
    public function setTld(string|null $tld): static
    {
        $this->tld = $tld;

        return $this;
    }

    /**
     * Get tld
     *
     * If no tld value set, method
     * sets and returns a default tld.
     *
     * @see getDefaultTld()
     *
     * @return string|null tld or null if no tld has been set
     */
    public function getTld(): string|null
    {
        if (!$this->hasTld()) {
            $this->setTld($this->getDefaultTld());
        }
        return $this->tld;
    }

    /**
     * Check if tld has been set
     *
     * @return bool True if tld has been set, false if not
     */
    public function hasTld(): bool
    {
        return isset($this->tld);
    }

    /**
     * Get a default tld value, if any is available
     *
     * @return string|null Default tld value or null if no default value is available
     */
    public function getDefaultTld(): string|null
    {
        return null;
    }
}
