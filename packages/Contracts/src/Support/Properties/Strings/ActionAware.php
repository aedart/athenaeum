<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Action Aware
 *
 * Component is aware of string "action"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ActionAware
{
    /**
     * Set action
     *
     * @param string|null $action A process or fact of doing something
     *
     * @return self
     */
    public function setAction(string|null $action): static;

    /**
     * Get action
     *
     * If no action value set, method
     * sets and returns a default action.
     *
     * @see getDefaultAction()
     *
     * @return string|null action or null if no action has been set
     */
    public function getAction(): string|null;

    /**
     * Check if action has been set
     *
     * @return bool True if action has been set, false if not
     */
    public function hasAction(): bool;

    /**
     * Get a default action value, if any is available
     *
     * @return string|null Default action value or null if no default value is available
     */
    public function getDefaultAction(): string|null;
}
