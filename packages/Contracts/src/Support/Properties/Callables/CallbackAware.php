<?php

namespace Aedart\Contracts\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Callback Aware
 *
 * Component is aware of callable "callback"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Callables
 */
interface CallbackAware
{
    /**
     * Set callback
     *
     * @param callable|null $callback Callback method
     *
     * @return self
     */
    public function setCallback(callable|null $callback): static;

    /**
     * Get callback
     *
     * If no callback value set, method
     * sets and returns a default callback.
     *
     * @see getDefaultCallback()
     *
     * @return callable|null callback or null if no callback has been set
     */
    public function getCallback(): callable|null;

    /**
     * Check if callback has been set
     *
     * @return bool True if callback has been set, false if not
     */
    public function hasCallback(): bool;

    /**
     * Get a default callback value, if any is available
     *
     * @return callable|null Default callback value or null if no default value is available
     */
    public function getDefaultCallback(): callable|null;
}
