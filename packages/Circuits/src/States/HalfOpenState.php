<?php

namespace Aedart\Circuits\States;

use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\States\Lockable;

/**
 * Half-Open State
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreaker::HALF_OPEN
 * @see \Aedart\Contracts\Circuits\States\Lockable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class HalfOpenState extends BaseState implements Lockable
{
    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return CircuitBreaker::HALF_OPEN;
    }
}
