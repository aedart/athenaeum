<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Uuid Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\UuidAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait UuidTrait
{
    /**
     * Universally Unique Identifier (UUID)
     *
     * @var string|null
     */
    protected string|null $uuid = null;

    /**
     * Set uuid
     *
     * @param string|null $identifier Universally Unique Identifier (UUID)
     *
     * @return self
     */
    public function setUuid(string|null $identifier): static
    {
        $this->uuid = $identifier;

        return $this;
    }

    /**
     * Get uuid
     *
     * If no uuid value set, method
     * sets and returns a default uuid.
     *
     * @see getDefaultUuid()
     *
     * @return string|null uuid or null if no uuid has been set
     */
    public function getUuid(): string|null
    {
        if (!$this->hasUuid()) {
            $this->setUuid($this->getDefaultUuid());
        }
        return $this->uuid;
    }

    /**
     * Check if uuid has been set
     *
     * @return bool True if uuid has been set, false if not
     */
    public function hasUuid(): bool
    {
        return isset($this->uuid);
    }

    /**
     * Get a default uuid value, if any is available
     *
     * @return string|null Default uuid value or null if no default value is available
     */
    public function getDefaultUuid(): string|null
    {
        return null;
    }
}
