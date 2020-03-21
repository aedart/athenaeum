<?php

namespace Aedart\Support\Facades;

use Aedart\Contracts\Container\IoC;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Facade;

/**
 * IoC Facade
 *
 * @see \Illuminate\Support\Facades\Facade
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Facades
 */
class IoCFacade extends Facade
{
    /**
     * Attempts to resolve given type from the IoC or defaults
     *
     * Warning: Unlike Laravel's {@see Container::make} method,
     * this method will NOT fail, in case that given type cannot
     * be built!
     *
     * @see Container::make
     *
     * @param string $abstract The type to attempt resolving
     * @param mixed $default [optional] Default value to return. Is NOT processed by IoC.
     *                      If callback is provided, the callback is invoked and it's resulting value is returned.
     * @param array $parameters [optional] Evt. parameters to be passed on to given type (contextual binding)
     *
     * @return mixed
     */
    public static function tryMake(string $abstract, $default = null, array $parameters = [])
    {
        /** @var Container|IoC $container */
        $container = static::getFacadeRoot();

        // If we have no container, resolve to default if possible
        if (!isset($container)) {
            return static::resolveDefault($default);
        }

        try {
            // Attempt to resolve from IoC. If type is bound or
            // buildable, then this will work fine.
            return $container->make($abstract, $parameters);
        } catch (BindingResolutionException $e) {
            // If unable to build given type, just return the default
            return static::resolveDefault($default);
        }
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'app';
    }

    /**
     * Resolves the default value.
     *
     * @param mixed $default If callback is provided, the callback is invoked
     *                      and it's resulting value is returned.
     *
     * @return mixed
     */
    protected static function resolveDefault($default = null)
    {
        if (is_callable($default)) {
            return $default();
        }

        return $default;
    }
}
