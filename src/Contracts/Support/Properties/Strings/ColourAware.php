<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Colour Aware
 *
 * Component is aware of string "colour"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ColourAware
{
    /**
     * Set colour
     *
     * @param string|null $colour Name of colour or colour value, e.g. RGB, CMYK, HSL or other format
     *
     * @return self
     */
    public function setColour(?string $colour);

    /**
     * Get colour
     *
     * If no "colour" value set, method
     * sets and returns a default "colour".
     *
     * @see getDefaultColour()
     *
     * @return string|null colour or null if no colour has been set
     */
    public function getColour() : ?string;

    /**
     * Check if "colour" has been set
     *
     * @return bool True if "colour" has been set, false if not
     */
    public function hasColour() : bool;

    /**
     * Get a default "colour" value, if any is available
     *
     * @return string|null Default "colour" value or null if no default value is available
     */
    public function getDefaultColour() : ?string;
}
