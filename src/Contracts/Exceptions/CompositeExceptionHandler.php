<?php

namespace Aedart\Contracts\Exceptions;

/**
 * Composite Exception Handler
 *
 * Defers actual exception handling to registered child exception handlers.
 *
 * @see ChildExceptionHandler
 * @see ExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface CompositeExceptionHandler extends ChildExceptionHandler
{
    /**
     * Add multiple child exception handlers
     *
     * @see add
     *
     * @param ChildExceptionHandler[] $handlers
     *
     * @return self
     */
    public function addMultiple(array $handlers = []);

    /**
     * Add a child exception handler
     *
     * Method sets this composite handler as the given child's
     * parent.
     *
     * @param ChildExceptionHandler $handler
     *
     * @return self
     */
    public function add(ChildExceptionHandler $handler);

    /**
     * Returns the list of child exception handlers
     *
     * @return ChildExceptionHandler[]
     */
    public function children() : array ;
}
