<?php

namespace Aedart\Contracts\Circuits\Exceptions;

/**
 * Has Context
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Exceptions
 */
interface HasContext
{
    /**
     * Arbitrary data associated with exception
     * or failure
     *
     * @return array
     */
    public function context(): array;
}
