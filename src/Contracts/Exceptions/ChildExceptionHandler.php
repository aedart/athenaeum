<?php

namespace Aedart\Contracts\Exceptions;

/**
 * Child Exception Handler
 *
 * A "child" exception handler that is aware of it's parent handler
 *
 * @see CompositeExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface ChildExceptionHandler extends ExceptionHandler
{
    /**
     * Set the parent of the exception handler
     *
     * @param CompositeExceptionHandler|null $handler
     *
     * @return self
     */
    public function setParent(?CompositeExceptionHandler $handler);

    /**
     * Get the parent exception handler
     *
     * @return CompositeExceptionHandler|null
     */
    public function getParent() : ?CompositeExceptionHandler ;
}
