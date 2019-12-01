<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Action Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ActionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ActionTrait
{
    /**
     * A process or fact of doing something
     *
     * @var string|null
     */
    protected ?string $action = null;

    /**
     * Set action
     *
     * @param string|null $action A process or fact of doing something
     *
     * @return self
     */
    public function setAction(?string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * If no "action" value set, method
     * sets and returns a default "action".
     *
     * @see getDefaultAction()
     *
     * @return string|null action or null if no action has been set
     */
    public function getAction() : ?string
    {
        if ( ! $this->hasAction()) {
            $this->setAction($this->getDefaultAction());
        }
        return $this->action;
    }

    /**
     * Check if "action" has been set
     *
     * @return bool True if "action" has been set, false if not
     */
    public function hasAction() : bool
    {
        return isset($this->action);
    }

    /**
     * Get a default "action" value, if any is available
     *
     * @return string|null Default "action" value or null if no default value is available
     */
    public function getDefaultAction() : ?string
    {
        return null;
    }
}
