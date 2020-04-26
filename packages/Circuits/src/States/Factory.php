<?php

namespace Aedart\Circuits\States;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Exceptions\UnknownState;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;

/**
 * States Factory
 *
 * @see \Aedart\Contracts\Circuits\States\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
class Factory implements StatesFactory
{
    use Concerns\Identifiers;

    /**
     * @inheritDoc
     */
    public function make(int $id, ?int $previous = null, $createdAt = null, $expiresAt = null): State
    {
        return $this->makeByArray([
            'id' => $id,
            'previous' => $previous,
            'created_at' => $createdAt,
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * @inheritDoc
     */
    public function makeByArray(array $data): State
    {
        if (!isset($data['id'])){
            throw new UnknownState('Cannot create state, missing "id"; state identifier');
        }

        $id = $data['id'];
        $this->assertStateIdentifier($id);

        /** @var State $class */
        $class = null;

        switch ($id) {

            case CircuitBreaker::CLOSED:
            default:
                $class = ClosedState::class;
                break;

            case CircuitBreaker::OPEN:
                $class = OpenState::class;
                break;

            case CircuitBreaker::HALF_OPEN:
                $class = HalfOpenState::class;
                break;
        }

        return $class::make($data);
    }
}
