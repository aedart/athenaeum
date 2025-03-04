<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Kind Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\KindAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait KindTrait
{
    /**
     * The kind of object this represents, e.g. human, organisation, group, individual...etc
     *
     * @var string|null
     */
    protected string|null $kind = null;

    /**
     * Set kind
     *
     * @param string|null $kind The kind of object this represents, e.g. human, organisation, group, individual...etc
     *
     * @return self
     */
    public function setKind(string|null $kind): static
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * If no kind value set, method
     * sets and returns a default kind.
     *
     * @see getDefaultKind()
     *
     * @return string|null kind or null if no kind has been set
     */
    public function getKind(): string|null
    {
        if (!$this->hasKind()) {
            $this->setKind($this->getDefaultKind());
        }
        return $this->kind;
    }

    /**
     * Check if kind has been set
     *
     * @return bool True if kind has been set, false if not
     */
    public function hasKind(): bool
    {
        return isset($this->kind);
    }

    /**
     * Get a default kind value, if any is available
     *
     * @return string|null Default kind value or null if no default value is available
     */
    public function getDefaultKind(): string|null
    {
        return null;
    }
}
