<?php

namespace Aedart\Contracts\Exceptions;

use Throwable;

/**
 * Exception Handler Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface Factory
{
    /**
     * Creates or obtains exception handler
     *
     * @return ExceptionHandler
     *
     * @throws Throwable If unable to obtain handler instance
     */
    public function make() : ExceptionHandler ;
}
