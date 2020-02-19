<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Host Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\HostAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait HostTrait
{
    /**
     * Identifier of a host
     *
     * @var string|null
     */
    protected ?string $host = null;

    /**
     * Set host
     *
     * @param string|null $identifier Identifier of a host
     *
     * @return self
     */
    public function setHost(?string $identifier)
    {
        $this->host = $identifier;

        return $this;
    }

    /**
     * Get host
     *
     * If no "host" value set, method
     * sets and returns a default "host".
     *
     * @see getDefaultHost()
     *
     * @return string|null host or null if no host has been set
     */
    public function getHost(): ?string
    {
        if (!$this->hasHost()) {
            $this->setHost($this->getDefaultHost());
        }
        return $this->host;
    }

    /**
     * Check if "host" has been set
     *
     * @return bool True if "host" has been set, false if not
     */
    public function hasHost(): bool
    {
        return isset($this->host);
    }

    /**
     * Get a default "host" value, if any is available
     *
     * @return string|null Default "host" value or null if no default value is available
     */
    public function getDefaultHost(): ?string
    {
        return null;
    }
}
