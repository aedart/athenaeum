<?php

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Support\Facades\IoCFacade;
use Illuminate\Contracts\Foundation\Application;

if (!function_exists('paths')) {
    /**
     * Get he paths container
     *
     * @return PathsContainer|Application
     */
    function paths(): PathsContainer|Application
    {
        // Try to resolve the Paths Container if possible. If not,
        // try to default to Laravel's application. This is in case
        // that this file somehow is loaded first within a full
        // Laravel application and thus might otherwise cause a
        // conflict with the path-helpers defined within Laravel's
        // foundation package.
        return IoCFacade::tryMake(
            PathsContainer::class,
            IoCFacade::tryMake(Application::class)
        );
    }
}

if (!function_exists('base_path')) {
    /**
     * Get a path within the "base" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function base_path(string $path = ''): string
    {
        return paths()->basePath($path);
    }
}

if (!function_exists('bootstrap_path')) {
    /**
     * Get a path within the "bootstrap" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function bootstrap_path(string $path = ''): string
    {
        return paths()->bootstrapPath($path);
    }
}

if (!function_exists('config_path')) {
    /**
     * Get a path within the "config" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function config_path(string $path = ''): string
    {
        return paths()->configPath($path);
    }
}

if (!function_exists('lang_path')) {
    /**
     * Get path to language files.
     *
     * @param  string  $path  [optional]
     *
     * @return string
     */
    function lang_path(string $path = ''): string
    {
        return paths()->langPath($path);
    }
}

if (!function_exists('database_path')) {
    /**
     * Get a path with the "database" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function database_path(string $path = ''): string
    {
        return paths()->databasePath($path);
    }
}

if (!function_exists('environment_path')) {
    /**
     * Get a path within the "environment" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function environment_path(string $path = ''): string
    {
        $app = paths();
        if ($app instanceof PathsContainer) {
            return $app->environmentPath($path);
        }

        return $app->environmentPath() . DIRECTORY_SEPARATOR . $path;
    }
}

if (!function_exists('resource_path')) {
    /**
     * Get a path within the "resources" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function resource_path(string $path = ''): string
    {
        return paths()->resourcePath($path);
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get a path within the "storage" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function storage_path(string $path = ''): string
    {
        $app = paths();
        if ($app instanceof PathsContainer) {
            return $app->storagePath($path);
        }

        return $app->storagePath($path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get a path within the "public" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    function public_path(string $path = ''): string
    {
        $app = paths();
        if ($app instanceof PathsContainer) {
            return $app->publicPath($path);
        }

        return $app->publicPath() . DIRECTORY_SEPARATOR . $path;
    }
}
