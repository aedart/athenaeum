<?php

namespace Aedart\Contracts\Circuits\States;

use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\State;
use DateTimeInterface;
use Throwable;

/**
 * State Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\States
 */
interface Factory
{
    /**
     * Returns a new {@see CircuitBreaker::CLOSED} state
     *
     * @param string $name
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     */
    public function makeClosedState(
        string $name,
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State;

    /**
     * Returns a new {@see CircuitBreaker::OPEN} state
     *
     * @param string $name
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     */
    public function makeOpenState(
        string $name,
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State;

    /**
     * Returns a new {@see CircuitBreaker::HALF_OPEN} state
     *
     * @param string $name
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     */
    public function makeHalfOpenState(
        string $name,
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State;

    /**
     * Returns a new state instance
     *
     * @param array $data
     *
     * @return State
     *
     * @throws Throwable
     */
    public function make(array $data): State;
}
