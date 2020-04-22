<?php

namespace Aedart\Contracts\Circuits\States;

use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\Store;

/**
 * State Serializer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\States
 */
interface Serializer
{
    /**
     * Convert (or serialise) given state into a format that a
     * {@see Store} can persist
     *
     * @param State $state
     *
     * @return mixed
     */
    public function toStore(State $state);

    /**
     * Convert (or unserialise) persisted state into
     * a {@see State} instance
     *
     * @param mixed $state
     *
     * @return State
     */
    public function fromStore($state): State;
}
