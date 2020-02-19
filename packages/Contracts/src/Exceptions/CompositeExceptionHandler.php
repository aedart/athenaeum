<?php

namespace Aedart\Contracts\Exceptions;

use Throwable;

/**
 * Composite Exception Handler
 *
 * Able to delegate actual exception handling to "lead" exception
 * handlers.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface CompositeExceptionHandler extends ExceptionHandler
{
    /**
     * Add a "leaf" exception handler
     *
     * @param string|ExceptionHandler $handler Class path or instance
     *
     * @throws Throwable If given handler is invalid
     *
     * @return self
     */
    public function addHandler($handler);

    /**
     * Set the "leaf" exception handlers
     *
     * @param string[]|ExceptionHandler[] $handlers [optional] List of class paths or instances
     *
     * @return self
     *
     * @throws Throwable If a handler is invalid
     */
    public function setHandlers(array $handlers = []);

    /**
     * Returns the list of "leaf" exception handlers
     *
     * @return ExceptionHandler[]
     */
    public function getHandlers(): array;
}
