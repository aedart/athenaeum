<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Edition Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\EditionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait EditionTrait
{
    /**
     * The version of a published text, e.g. book, article, newspaper, report... etc
     *
     * @var string|null
     */
    protected string|null $edition = null;

    /**
     * Set edition
     *
     * @param string|null $edition The version of a published text, e.g. book, article, newspaper, report... etc
     *
     * @return self
     */
    public function setEdition(string|null $edition): static
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition
     *
     * If no edition value set, method
     * sets and returns a default edition.
     *
     * @see getDefaultEdition()
     *
     * @return string|null edition or null if no edition has been set
     */
    public function getEdition(): string|null
    {
        if (!$this->hasEdition()) {
            $this->setEdition($this->getDefaultEdition());
        }
        return $this->edition;
    }

    /**
     * Check if edition has been set
     *
     * @return bool True if edition has been set, false if not
     */
    public function hasEdition(): bool
    {
        return isset($this->edition);
    }

    /**
     * Get a default edition value, if any is available
     *
     * @return string|null Default edition value or null if no default value is available
     */
    public function getDefaultEdition(): string|null
    {
        return null;
    }
}
