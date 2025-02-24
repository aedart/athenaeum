<?php

namespace Aedart\Contracts\Support\Helpers\Debug;

use Illuminate\Contracts\Debug\ExceptionHandler;

/**
 * Exception Handler Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Debug
 */
interface ExceptionHandlerAware
{
    /**
     * Set exception handler
     *
     * @param ExceptionHandler|null $handler Exception Handler instance
     *
     * @return self
     */
    public function setExceptionHandler(ExceptionHandler|null $handler): static;

    /**
     * Get exception handler
     *
     * If no exception handler has been set, this method will
     * set and return a default exception handler, if any such
     * value is available
     *
     * @return ExceptionHandler|null exception handler or null if none exception handler has been set
     */
    public function getExceptionHandler(): ExceptionHandler|null;

    /**
     * Check if exception handler has been set
     *
     * @return bool True if exception handler has been set, false if not
     */
    public function hasExceptionHandler(): bool;

    /**
     * Get a default exception handler value, if any is available
     *
     * @return ExceptionHandler|null A default exception handler value or Null if no default value is available
     */
    public function getDefaultExceptionHandler(): ExceptionHandler|null;
}
