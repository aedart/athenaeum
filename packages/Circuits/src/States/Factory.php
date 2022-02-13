<?php

namespace Aedart\Circuits\States;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Exceptions\UnknownState;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;
use DateTimeInterface;

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
    public function make(
        int $id,
        int|null $previous = null,
        DateTimeInterface|string|null $createdAt = null,
        DateTimeInterface|string|null $expiresAt = null
    ): State
    {
        return $this->makeFromArray([
            'id' => $id,
            'previous' => $previous,
            'created_at' => $createdAt,
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * @inheritDoc
     */
    public function makeFromArray(array $data): State
    {
        if (!isset($data['id'])) {
            throw new UnknownState('Cannot create state, missing "id"; state identifier');
        }

        $id = $data['id'];
        $this->assertStateIdentifier($id);

        return match ($id) {
            CircuitBreaker::CLOSED => ClosedState::make($data),
            CircuitBreaker::OPEN => OpenState::make($data),
            CircuitBreaker::HALF_OPEN => HalfOpenState::make($data),

            default => ClosedState::make($data),
        };
    }
}
