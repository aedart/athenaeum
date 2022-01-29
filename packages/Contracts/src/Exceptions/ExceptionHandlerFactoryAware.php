<?php

namespace Aedart\Contracts\Exceptions;

/**
 * Exception Handler Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface ExceptionHandlerFactoryAware
{
    /**
     * Set exception handler factory
     *
     * @param Factory|null $factory Exception Handler Factory instance
     *
     * @return self
     */
    public function setExceptionHandlerFactory(Factory|null $factory): static;

    /**
     * Get exception handler factory
     *
     * If no exception handler factory has been set, this method will
     * set and return a default exception handler factory, if any such
     * value is available
     *
     * @return Factory|null exception handler factory or null if none exception handler factory has been set
     */
    public function getExceptionHandlerFactory(): Factory|null;

    /**
     * Check if exception handler factory has been set
     *
     * @return bool True if exception handler factory has been set, false if not
     */
    public function hasExceptionHandlerFactory(): bool;

    /**
     * Get a default exception handler factory value, if any is available
     *
     * @return Factory|null A default exception handler factory value or Null if no default value is available
     */
    public function getDefaultExceptionHandlerFactory(): Factory|null;
}
