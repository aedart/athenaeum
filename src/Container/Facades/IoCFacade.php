<?php

namespace Aedart\Container\Facades;

use Aedart\Contracts\Container\IoC;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Facade;

/**
 * IoC Facade
 *
 * @see \Illuminate\Support\Facades\Facade
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Container\Facades
 */
class IoCFacade extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'app';
    }

    /**
     * Resolve abstract from IoC or return a default
     *
     * @param string $abstract
     * @param mixed $default [optional] Default instance to return, if abstract
     *                       isn't bound in the IoC
     *
     * @return mixed
     */
    public static function make(string $abstract, $default = null)
    {
        /** @var Container|IoC $container */
        $container = static::getFacadeRoot();
        if(!isset($container)){
            return $default;
        }

        if($container->bound($abstract)){
            return $container->make($abstract);
        }

        return $default;
    }
}
