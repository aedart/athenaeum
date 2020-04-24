<?php

namespace Aedart\Contracts\Circuits;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * Circuit Breaker State
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface State extends Arrayable,
    JsonSerializable,
    Jsonable
{
    /**
     * Returns the numeric identifier of this state
     *
     * @return int
     */
    public function id(): int;

    /**
     * Returns the name of this state
     *
     * @return string
     */
    public function name(): string;

    /**
     * Date and time of when this state was created
     * (or switched to)
     *
     * @return DateTimeInterface
     */
    public function createdAt(): DateTimeInterface;

    /**
     * Date and time of when this state expires
     *
     * @return DateTimeInterface|null Null if state does not expire
     */
    public function expiresAt(): ?DateTimeInterface;

    /**
     * Determine if this state has expired
     *
     * @return bool
     */
    public function hasExpired(): bool;

    /**
     * Returns the previous state's identifier, if
     * any is available
     *
     * @return int|null
     */
    public function previous(): ?int;
}
