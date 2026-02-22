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
     * @param class-string<ExceptionHandler>|ExceptionHandler  $handler Class path or exception handler instance
     *
     * @return self
     *
     * @throws Throwable If given handler is invalid
     */
    public function addHandler(ExceptionHandler|string $handler): static;

    /**
     * Set the "leaf" exception handlers
     *
     * @param array<class-string<ExceptionHandler>|ExceptionHandler> $handlers [optional] List of class paths or instances
     *
     * @return self
     *
     * @throws Throwable If a handler is invalid
     */
    public function setHandlers(array $handlers = []): static;

    /**
     * Returns the list of "leaf" exception handlers
     *
     * @return ExceptionHandler[]
     */
    public function getHandlers(): array;
}
