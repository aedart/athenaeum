<?php

namespace Aedart\Container;

use Aedart\Contracts\Container\IoC as IoCInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Contracts\Foundation\Application;
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
     * {@inheritdoc}
     */
    public static function getInstance()
    {
        /** @var Application|static $container */
        $container = parent::getInstance();

        $container
            ->registerMainBindings()
            ->setFacadeApplication();

        return $container;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(): void
    {
        // Flush all bindings
        $this->flush();

        // Clear facade instances and application
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);

        // Clear container instance
        static::setInstance(null);
    }

    /**
     * Register the "main" bindings
     *
     * @return self
     */
    public function registerMainBindings()
    {
        // Self register as "app" and set Facade application
        $key = 'app';

        $this->instance($key, $this);
        $this->alias($key, ContainerInterface::class);
        $this->alias($key, IoCInterface::class);
        $this->alias($key, PsrContainerInterface::class);

        return $this;
    }

    /**
     * Set the Facade's application
     *
     * @return self
     */
    public function setFacadeApplication()
    {
        // Force set the facade's application to this container.
        // NOTE: This works only because Laravel has yet to
        // use typed arguments.
        Facade::setFacadeApplication($this);

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/
}
