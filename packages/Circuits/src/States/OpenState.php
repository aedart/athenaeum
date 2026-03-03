<?php

namespace Aedart\Circuits\States;

use Aedart\Contracts\Circuits\States\Identifier;

/**
 * Open State
 *
 * @see \Aedart\Contracts\Circuits\States\Identifier::OPEN
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class OpenState extends BaseState
{
    /**
     * @inheritDoc
     */
    public function id(): Identifier
    {
        return Identifier::OPEN;
    }
}
