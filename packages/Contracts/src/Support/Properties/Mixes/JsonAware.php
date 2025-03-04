<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Json Aware
 *
 * Component is aware of mixed "json"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixes
 */
interface JsonAware
{
    /**
     * Set json
     *
     * @param mixed $json JavaScript Object Notation (JSON)
     *
     * @return self
     */
    public function setJson(mixed $json): static;

    /**
     * Get json
     *
     * If no json value set, method
     * sets and returns a default json.
     *
     * @see getDefaultJson()
     *
     * @return mixed json or null if no json has been set
     */
    public function getJson(): mixed;

    /**
     * Check if json has been set
     *
     * @return bool True if json has been set, false if not
     */
    public function hasJson(): bool;

    /**
     * Get a default json value, if any is available
     *
     * @return mixed Default json value or null if no default value is available
     */
    public function getDefaultJson(): mixed;
}
