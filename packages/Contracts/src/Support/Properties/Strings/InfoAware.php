<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Info Aware
 *
 * Component is aware of string "info"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface InfoAware
{
    /**
     * Set info
     *
     * @param string|null $text Information about someone or something
     *
     * @return self
     */
    public function setInfo(string|null $text): static;

    /**
     * Get info
     *
     * If no info value set, method
     * sets and returns a default info.
     *
     * @see getDefaultInfo()
     *
     * @return string|null info or null if no info has been set
     */
    public function getInfo(): string|null;

    /**
     * Check if info has been set
     *
     * @return bool True if info has been set, false if not
     */
    public function hasInfo(): bool;

    /**
     * Get a default info value, if any is available
     *
     * @return string|null Default info value or null if no default value is available
     */
    public function getDefaultInfo(): string|null;
}
