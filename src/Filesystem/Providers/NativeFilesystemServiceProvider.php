<?php

namespace Aedart\Filesystem\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

/**
 * Native Filesystem Service Provider
 *
 * Binds the "native" filesystem component
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filesystem\Providers
 */
class NativeFilesystemServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $key = 'files';

        $this->app->singleton($key, Filesystem::class);

        $this->app->alias($key, Filesystem::class);
    }
}
