<?php

namespace Aedart\Circuits\States;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Exceptions\UnknownState;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;
use Aedart\Contracts\Circuits\States\Identifier;
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
        int|Identifier $id,
        int|Identifier|null $previous = null,
        DateTimeInterface|string|null $createdAt = null,
        DateTimeInterface|string|null $expiresAt = null
    ): State {
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

        $id = $this->resolveStateIdentifier($data['id']);

        return match ($id) {
            Identifier::CLOSED => ClosedState::make($data),
            Identifier::OPEN => OpenState::make($data),
            Identifier::HALF_OPEN => HalfOpenState::make($data),
        };
    }
}
