<?php

namespace Aedart\Circuits\States;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Closed State
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreaker::CLOSED
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class ClosedState extends BaseState
{
    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return CircuitBreaker::CLOSED;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'closed';
    }
}
