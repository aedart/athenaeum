<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Edition Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\EditionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait EditionTrait
{
    /**
     * The version of a published text, e.g. book, article, newspaper, report... etc
     *
     * @var int|null
     */
    protected int|null $edition = null;

    /**
     * Set edition
     *
     * @param int|null $edition The version of a published text, e.g. book, article, newspaper, report... etc
     *
     * @return self
     */
    public function setEdition(int|null $edition): static
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
     * @return int|null edition or null if no edition has been set
     */
    public function getEdition(): int|null
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
     * @return int|null Default edition value or null if no default value is available
     */
    public function getDefaultEdition(): int|null
    {
        return null;
    }
}
