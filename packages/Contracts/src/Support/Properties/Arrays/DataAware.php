<?php

namespace Aedart\Contracts\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Data Aware
 *
 * Component is aware of array "data"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Arrays
 */
interface DataAware
{
    /**
     * Set data
     *
     * @param array|null $values A list (array) containing a set of values
     *
     * @return self
     */
    public function setData(array|null $values): static;

    /**
     * Get data
     *
     * If no data value set, method
     * sets and returns a default data.
     *
     * @see getDefaultData()
     *
     * @return array|null data or null if no data has been set
     */
    public function getData(): array|null;

    /**
     * Check if data has been set
     *
     * @return bool True if data has been set, false if not
     */
    public function hasData(): bool;

    /**
     * Get a default data value, if any is available
     *
     * @return array|null Default data value or null if no default value is available
     */
    public function getDefaultData(): array|null;
}
