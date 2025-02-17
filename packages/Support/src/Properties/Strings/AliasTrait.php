<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Alias Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\AliasAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait AliasTrait
{
    /**
     * An alternate name of an item or component
     *
     * @var string|null
     */
    protected string|null $alias = null;

    /**
     * Set alias
     *
     * @param string|null $name An alternate name of an item or component
     *
     * @return self
     */
    public function setAlias(string|null $name): static
    {
        $this->alias = $name;

        return $this;
    }

    /**
     * Get alias
     *
     * If no alias value set, method
     * sets and returns a default alias.
     *
     * @see getDefaultAlias()
     *
     * @return string|null alias or null if no alias has been set
     */
    public function getAlias(): string|null
    {
        if (!$this->hasAlias()) {
            $this->setAlias($this->getDefaultAlias());
        }
        return $this->alias;
    }

    /**
     * Check if alias has been set
     *
     * @return bool True if alias has been set, false if not
     */
    public function hasAlias(): bool
    {
        return isset($this->alias);
    }

    /**
     * Get a default alias value, if any is available
     *
     * @return string|null Default alias value or null if no default value is available
     */
    public function getDefaultAlias(): string|null
    {
        return null;
    }
}
