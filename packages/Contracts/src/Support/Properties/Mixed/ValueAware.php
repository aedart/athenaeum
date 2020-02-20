<?php

namespace Aedart\Contracts\Support\Properties\Mixed;

/**
 * @deprecated Since v4.0, please use \Aedart\Contracts\Support\Properties\Mixes\ValueAware instead
 *
 * Value Aware
 *
 * Component is aware of mixed "value"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixed
 */
interface ValueAware
{
    /**
     * Set value
     *
     * @param mixed|null $value Value
     *
     * @return self
     */
    public function setValue($value);

    /**
     * Get value
     *
     * If no "value" value set, method
     * sets and returns a default "value".
     *
     * @see getDefaultValue()
     *
     * @return mixed|null value or null if no value has been set
     */
    public function getValue();

    /**
     * Check if "value" has been set
     *
     * @return bool True if "value" has been set, false if not
     */
    public function hasValue(): bool;

    /**
     * Get a default "value" value, if any is available
     *
     * @return mixed|null Default "value" value or null if no default value is available
     */
    public function getDefaultValue();
}
