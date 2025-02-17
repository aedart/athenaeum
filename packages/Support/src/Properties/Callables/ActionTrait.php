<?php

namespace Aedart\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Action Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Callables\ActionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Callables
 */
trait ActionTrait
{
    /**
     * Callback method
     *
     * @var callable|null
     */
    protected $action = null;

    /**
     * Set action
     *
     * @param callable|null $callback Callback method
     *
     * @return self
     */
    public function setAction(callable|null $callback): static
    {
        $this->action = $callback;

        return $this;
    }

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
    public function getAction(): callable|null
    {
        if (!$this->hasAction()) {
            $this->setAction($this->getDefaultAction());
        }
        return $this->action;
    }

    /**
     * Check if action has been set
     *
     * @return bool True if action has been set, false if not
     */
    public function hasAction(): bool
    {
        return isset($this->action);
    }

    /**
     * Get a default action value, if any is available
     *
     * @return callable|null Default action value or null if no default value is available
     */
    public function getDefaultAction(): callable|null
    {
        return null;
    }
}
