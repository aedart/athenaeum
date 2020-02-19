<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Edition Aware
 *
 * Component is aware of int "edition"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface EditionAware
{
    /**
     * Set edition
     *
     * @param int|null $edition The version of a published text, e.g. book, article, newspaper, report... etc
     *
     * @return self
     */
    public function setEdition(?int $edition);

    /**
     * Get edition
     *
     * If no "edition" value set, method
     * sets and returns a default "edition".
     *
     * @see getDefaultEdition()
     *
     * @return int|null edition or null if no edition has been set
     */
    public function getEdition(): ?int;

    /**
     * Check if "edition" has been set
     *
     * @return bool True if "edition" has been set, false if not
     */
    public function hasEdition(): bool;

    /**
     * Get a default "edition" value, if any is available
     *
     * @return int|null Default "edition" value or null if no default value is available
     */
    public function getDefaultEdition(): ?int;
}
