<?php

namespace Aedart\Core\Traits;

use Aedart\Contracts\Exceptions\Factory;
use Aedart\Support\Facades\IoCFacade;

/**
 * Exception Handler Factory Trait
 *
 * @see \Aedart\Contracts\Exceptions\ExceptionHandlerFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Traits
 */
trait ExceptionHandlerFactoryTrait
{
    /**
     * Exception Handler Factory instance
     *
     * @var Factory|null
     */
    protected ?Factory $exceptionHandlerFactory = null;

    /**
     * Set exception handler factory
     *
     * @param Factory|null $factory Exception Handler Factory instance
     *
     * @return self
     */
    public function setExceptionHandlerFactory(?Factory $factory)
    {
        $this->exceptionHandlerFactory = $factory;

        return $this;
    }

    /**
     * Get exception handler factory
     *
     * If no exception handler factory has been set, this method will
     * set and return a default exception handler factory, if any such
     * value is available
     *
     * @return Factory|null exception handler factory or null if none exception handler factory has been set
     */
    public function getExceptionHandlerFactory(): ?Factory
    {
        if (!$this->hasExceptionHandlerFactory()) {
            $this->setExceptionHandlerFactory($this->getDefaultExceptionHandlerFactory());
        }
        return $this->exceptionHandlerFactory;
    }

    /**
     * Check if exception handler factory has been set
     *
     * @return bool True if exception handler factory has been set, false if not
     */
    public function hasExceptionHandlerFactory(): bool
    {
        return isset($this->exceptionHandlerFactory);
    }

    /**
     * Get a default exception handler factory value, if any is available
     *
     * @return Factory|null A default exception handler factory value or Null if no default value is available
     */
    public function getDefaultExceptionHandlerFactory(): ?Factory
    {
        return IoCFacade::tryMake(Factory::class);
    }
}
