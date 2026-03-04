<?php

namespace Aedart\Circuits\States;

use Aedart\Contracts\Circuits\States\Identifier;

/**
 * Closed State
 *
 * @see \Aedart\Contracts\Circuits\States\Identifier::CLOSED
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class ClosedState extends BaseState
{
    /**
     * @inheritDoc
     */
    public function id(): Identifier
    {
        return Identifier::CLOSED;
    }
}
