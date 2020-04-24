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
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     */
    public function makeClosedState(
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State;

    /**
     * Returns a new {@see CircuitBreaker::OPEN} state
     *
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     */
    public function makeOpenState(
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State;

    /**
     * Returns a new {@see CircuitBreaker::HALF_OPEN} state
     *
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     */
    public function makeHalfOpenState(
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State;

    /**
     * Returns a new state instance that matches given identifier
     *
     * @param int $id
     * @param int|null $previous [optional] Previous state identifier
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     *
     * @throws Throwable
     */
    public function makeById(
        int $id,
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
