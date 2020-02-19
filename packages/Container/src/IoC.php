<?php

namespace Aedart\Container;

use Aedart\Contracts\Container\IoC as IoCInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Support\Facades\Facade;
use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Inverse-of-Control (IoC) Service Container
 *
 * @see \Aedart\Contracts\Container\IoC
 * @see \Illuminate\Container\Container
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Container
 */
class IoC extends Container implements IoCInterface
{
    /**
     * @inheritdoc
     */
    public function flush()
    {
        parent::flush();

        $this->buildStack = [];
        $this->reboundCallbacks = [];
        $this->resolvingCallbacks = [];
        $this->afterResolvingCallbacks = [];
        $this->globalResolvingCallbacks = [];
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(): void
    {
        // Flush all bindings
        $this->flush();

        // Clear facade instances and application
        // in case this was registered as an application!
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);

        // Clear container instance
        static::setInstance(null);
    }

    /**
     * Register this container as the "app"
     *
     * <b>Warning</b>: Avoid invoking this method inside a Laravel application.
     * It will <i>highjack</i> the application instance! Method is intended for
     * testing purposes or when using as stand-alone outside a Laravel
     * application!
     *
     * @return self
     */
    public function registerAsApplication()
    {
        // Set the singleton instance
        static::setInstance($this);

        // Self register as "app"
        $key = 'app';
        $this->instance($key, $this);

        // Register aliases
        $this->alias($key, ContainerInterface::class);
        $this->alias($key, IoCInterface::class);
        $this->alias($key, PsrContainerInterface::class);

        // Force set the facade's application to this container.
        // Warning: This works only because Laravel has yet to
        // use typed arguments on the facade and service providers!
        Facade::setFacadeApplication($this);

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/
}
