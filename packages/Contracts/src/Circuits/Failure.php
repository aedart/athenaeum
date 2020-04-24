<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\HasContext;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * Failure
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface Failure extends HasContext,
    Arrayable,
    JsonSerializable,
    Jsonable
{
    /**
     * Returns failure reason, if any was given
     *
     * @return string|null
     */
    public function reason(): ?string;

    /**
     * Date and time of when this failure was reported
     *
     * @return DateTimeInterface
     */
    public function reportedAt(): DateTimeInterface;

    /**
     * Total amount of failures reported, at the
     * time of this failure
     *
     * @return int
     */
    public function amountFailures(): int;
}
