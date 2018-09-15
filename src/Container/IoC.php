<?php

namespace Aedart\Container;

use Aedart\Contracts\Container\IoC as IoCInterface;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

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
    static public function getInstance()
    {
        $container = parent::getInstance();

        // Self register as "app" and set Facade application
        $container->instance('app', $container);
        Facade::setFacadeApplication($container);

        return $container;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(): void
    {
        // Clear facade instances and application
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);

        // Clear container instance
        static::setInstance(null);
    }
}
