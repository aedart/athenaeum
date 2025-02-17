<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Colour Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ColourAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ColourTrait
{
    /**
     * Name of colour or colour value, e.g. RGB, CMYK, HSL or other format
     *
     * @var string|null
     */
    protected string|null $colour = null;

    /**
     * Set colour
     *
     * @param string|null $colour Name of colour or colour value, e.g. RGB, CMYK, HSL or other format
     *
     * @return self
     */
    public function setColour(string|null $colour): static
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * Get colour
     *
     * If no colour value set, method
     * sets and returns a default colour.
     *
     * @see getDefaultColour()
     *
     * @return string|null colour or null if no colour has been set
     */
    public function getColour(): string|null
    {
        if (!$this->hasColour()) {
            $this->setColour($this->getDefaultColour());
        }
        return $this->colour;
    }

    /**
     * Check if colour has been set
     *
     * @return bool True if colour has been set, false if not
     */
    public function hasColour(): bool
    {
        return isset($this->colour);
    }

    /**
     * Get a default colour value, if any is available
     *
     * @return string|null Default colour value or null if no default value is available
     */
    public function getDefaultColour(): string|null
    {
        return null;
    }
}
