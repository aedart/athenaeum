<?php

namespace Aedart\Support\Helpers\Debug;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Exceptions;

/**
 * ExceptionHandlerTrait
 *
 * @see \Aedart\Contracts\Support\Helpers\Debug\ExceptionHandlerAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Debug
 */
trait ExceptionHandlerTrait
{
    /**
     * Exception Handler instance
     *
     * @var ExceptionHandler|null
     */
    protected ExceptionHandler|null $exceptionHandler = null;

    /**
     * Set exception handler
     *
     * @param ExceptionHandler|null $handler Exception Handler instance
     *
     * @return self
     */
    public function setExceptionHandler(ExceptionHandler|null $handler): static
    {
        $this->exceptionHandler = $handler;

        return $this;
    }

    /**
     * Get exception handler
     *
     * If no exception handler has been set, this method will
     * set and return a default exception handler, if any such
     * value is available
     *
     * @return ExceptionHandler|null exception handler or null if none exception handler has been set
     */
    public function getExceptionHandler(): ExceptionHandler|null
    {
        if (!$this->hasExceptionHandler()) {
            $this->setExceptionHandler($this->getDefaultExceptionHandler());
        }
        return $this->exceptionHandler;
    }

    /**
     * Check if exception handler has been set
     *
     * @return bool True if exception handler has been set, false if not
     */
    public function hasExceptionHandler(): bool
    {
        return isset($this->exceptionHandler);
    }

    /**
     * Get a default exception handler value, if any is available
     *
     * @return ExceptionHandler|null A default exception handler value or Null if no default value is available
     */
    public function getDefaultExceptionHandler(): ExceptionHandler|null
    {
        return Exceptions::getFacadeRoot();
    }
}
