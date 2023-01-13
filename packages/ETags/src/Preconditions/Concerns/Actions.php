<?php

namespace Aedart\ETags\Preconditions\Concerns;

use Aedart\Contracts\ETags\Preconditions\Actions as PreconditionActions;

/**
 * Concerns Precondition Actions
 *
 * @see \Aedart\Contracts\ETags\Preconditions\HasActions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Concerns
 */
trait Actions
{
    /**
     * Precondition actions
     *
     * @var PreconditionActions
     */
    protected PreconditionActions $actions;

    /**
     * Set actions this precondition can invoke
     *
     * @param  PreconditionActions  $actions
     *
     * @return self
     */
    public function setActions(PreconditionActions $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Returns the actions this precondition can invoke
     *
     * @return PreconditionActions
     */
    public function getActions(): PreconditionActions
    {
        return $this->actions;
    }

    /**
     * Alias for {@see getActions()}
     *
     * @return PreconditionActions
     */
    public function actions(): PreconditionActions
    {
        return $this->getActions();
    }
}
