<?php

namespace Aedart\Contracts\Circuits\States;

use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\State;
use DateTimeInterface;

/**
 * State Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\States
 */
interface Factory
{
    /**
     * Creates a new state instance that matches given identifier
     *
     * @param int $id
     * @param int|null $previous [optional] Previous state identifier
     * @param  DateTimeInterface|string|null  $createdAt [optional]
     * @param  DateTimeInterface|string|null  $expiresAt [optional]
     *
     * @return State
     *
     * @throws UnknownStateException
     */
    public function make(
        int $id,
        int|null $previous = null,
        DateTimeInterface|string|null $createdAt = null,
        DateTimeInterface|string|null $expiresAt = null
    ): State;

    /**
     * Creates a new state instance
     *
     * @param array $data
     *
     * @return State
     *
     * @throws UnknownStateException
     */
    public function makeFromArray(array $data): State;
}
