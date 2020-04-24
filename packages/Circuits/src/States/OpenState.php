<?php

namespace Aedart\Circuits\States;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Open State
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreaker::OPEN
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class OpenState extends BaseState
{
    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return CircuitBreaker::OPEN;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'open';
    }
}
