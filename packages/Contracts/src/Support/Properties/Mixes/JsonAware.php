<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
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
     * @param mixed|null $json JavaScript Object Notation (JSON)
     *
     * @return self
     */
    public function setJson($json);

    /**
     * Get json
     *
     * If no "json" value set, method
     * sets and returns a default "json".
     *
     * @see getDefaultJson()
     *
     * @return mixed|null json or null if no json has been set
     */
    public function getJson();

    /**
     * Check if "json" has been set
     *
     * @return bool True if "json" has been set, false if not
     */
    public function hasJson(): bool;

    /**
     * Get a default "json" value, if any is available
     *
     * @return mixed|null Default "json" value or null if no default value is available
     */
    public function getDefaultJson();
}
