<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Edition Aware
 *
 * Component is aware of string "edition"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface EditionAware
{
    /**
     * Set edition
     *
     * @param string|null $edition The version of a published text, e.g. book, article, newspaper, report... etc
     *
     * @return self
     */
    public function setEdition(string|null $edition): static;

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
    public function getEdition(): string|null;

    /**
     * Check if edition has been set
     *
     * @return bool True if edition has been set, false if not
     */
    public function hasEdition(): bool;

    /**
     * Get a default edition value, if any is available
     *
     * @return string|null Default edition value or null if no default value is available
     */
    public function getDefaultEdition(): string|null;
}
