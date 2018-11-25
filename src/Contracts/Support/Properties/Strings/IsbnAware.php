<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Isbn Aware
 *
 * Component is aware of string "isbn"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IsbnAware
{
    /**
     * Set isbn
     *
     * @param string|null $isbn International Standard Book Number (ISBN)
     *
     * @return self
     */
    public function setIsbn(?string $isbn);

    /**
     * Get isbn
     *
     * If no "isbn" value set, method
     * sets and returns a default "isbn".
     *
     * @see getDefaultIsbn()
     *
     * @return string|null isbn or null if no isbn has been set
     */
    public function getIsbn() : ?string;

    /**
     * Check if "isbn" has been set
     *
     * @return bool True if "isbn" has been set, false if not
     */
    public function hasIsbn() : bool;

    /**
     * Get a default "isbn" value, if any is available
     *
     * @return string|null Default "isbn" value or null if no default value is available
     */
    public function getDefaultIsbn() : ?string;
}
