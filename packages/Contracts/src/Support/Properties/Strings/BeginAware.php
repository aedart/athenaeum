<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Begin Aware
 *
 * Component is aware of string "begin"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface BeginAware
{
    /**
     * Set begin
     *
     * @param string|null $location Location, index or some other identifier of where something begins
     *
     * @return self
     */
    public function setBegin(string|null $location): static;

    /**
     * Get begin
     *
     * If no begin value set, method
     * sets and returns a default begin.
     *
     * @see getDefaultBegin()
     *
     * @return string|null begin or null if no begin has been set
     */
    public function getBegin(): string|null;

    /**
     * Check if begin has been set
     *
     * @return bool True if begin has been set, false if not
     */
    public function hasBegin(): bool;

    /**
     * Get a default begin value, if any is available
     *
     * @return string|null Default begin value or null if no default value is available
     */
    public function getDefaultBegin(): string|null;
}
