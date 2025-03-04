<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Key Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\KeyAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait KeyTrait
{
    /**
     * Key, e.g. indexing key, encryption key or other type of key
     *
     * @var string|null
     */
    protected string|null $key = null;

    /**
     * Set key
     *
     * @param string|null $key Key, e.g. indexing key, encryption key or other type of key
     *
     * @return self
     */
    public function setKey(string|null $key): static
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * If no key value set, method
     * sets and returns a default key.
     *
     * @see getDefaultKey()
     *
     * @return string|null key or null if no key has been set
     */
    public function getKey(): string|null
    {
        if (!$this->hasKey()) {
            $this->setKey($this->getDefaultKey());
        }
        return $this->key;
    }

    /**
     * Check if key has been set
     *
     * @return bool True if key has been set, false if not
     */
    public function hasKey(): bool
    {
        return isset($this->key);
    }

    /**
     * Get a default key value, if any is available
     *
     * @return string|null Default key value or null if no default value is available
     */
    public function getDefaultKey(): string|null
    {
        return null;
    }
}
