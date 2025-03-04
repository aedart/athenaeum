<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Information Aware
 *
 * Component is aware of string "information"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface InformationAware
{
    /**
     * Set information
     *
     * @param string|null $text Information about someone or something
     *
     * @return self
     */
    public function setInformation(string|null $text): static;

    /**
     * Get information
     *
     * If no information value set, method
     * sets and returns a default information.
     *
     * @see getDefaultInformation()
     *
     * @return string|null information or null if no information has been set
     */
    public function getInformation(): string|null;

    /**
     * Check if information has been set
     *
     * @return bool True if information has been set, false if not
     */
    public function hasInformation(): bool;

    /**
     * Get a default information value, if any is available
     *
     * @return string|null Default information value or null if no default value is available
     */
    public function getDefaultInformation(): string|null;
}
