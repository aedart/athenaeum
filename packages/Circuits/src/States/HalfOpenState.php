<?php

namespace Aedart\Circuits\States;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Half-Open State
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreaker::HALF_OPEN
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class HalfOpenState extends BaseState
{
    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return CircuitBreaker::HALF_OPEN;
    }
}
