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
    public function identifier(): int;

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
    public function createAt(): DateTimeInterface;

    /**
     * Returns the previous state's identifier, if
     * any is available
     *
     * @return int|null
     */
    public function previous(): ?int;
}
