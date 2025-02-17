<?php

namespace Aedart\Contracts\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Action Aware
 *
 * Component is aware of callable "action"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Callables
 */
interface ActionAware
{
    /**
     * Set action
     *
     * @param callable|null $callback Callback method
     *
     * @return self
     */
    public function setAction(callable|null $callback): static;

    /**
     * Get action
     *
     * If no action value set, method
     * sets and returns a default action.
     *
     * @see getDefaultAction()
     *
     * @return callable|null action or null if no action has been set
     */
    public function getAction(): callable|null;

    /**
     * Check if action has been set
     *
     * @return bool True if action has been set, false if not
     */
    public function hasAction(): bool;

    /**
     * Get a default action value, if any is available
     *
     * @return callable|null Default action value or null if no default value is available
     */
    public function getDefaultAction(): callable|null;
}
