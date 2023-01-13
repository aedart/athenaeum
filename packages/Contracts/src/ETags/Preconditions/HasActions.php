<?php

namespace Aedart\Contracts\ETags\Preconditions;

/**
 * Has Actions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface HasActions
{
    /**
     * Set actions this precondition can invoke
     *
     * @param  Actions  $actions
     *
     * @return self
     */
    public function setActions(Actions $actions): static;

    /**
     * Returns the actions this precondition can invoke
     *
     * @return Actions
     */
    public function getActions(): Actions;

    /**
     * Alias for {@see getActions()}
     *
     * @return Actions
     */
    public function actions(): Actions;
}