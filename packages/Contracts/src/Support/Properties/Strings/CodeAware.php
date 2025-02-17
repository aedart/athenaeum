<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Code Aware
 *
 * Component is aware of string "code"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CodeAware
{
    /**
     * Set code
     *
     * @param string|null $code The code for something, e.g. language code, classification code, or perhaps an artifacts identifier
     *
     * @return self
     */
    public function setCode(string|null $code): static;

    /**
     * Get code
     *
     * If no code value set, method
     * sets and returns a default code.
     *
     * @see getDefaultCode()
     *
     * @return string|null code or null if no code has been set
     */
    public function getCode(): string|null;

    /**
     * Check if code has been set
     *
     * @return bool True if code has been set, false if not
     */
    public function hasCode(): bool;

    /**
     * Get a default code value, if any is available
     *
     * @return string|null Default code value or null if no default value is available
     */
    public function getDefaultCode(): string|null;
}
