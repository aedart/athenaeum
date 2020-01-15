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
     * Singleton bindings
     *
     * @var array
     */
    public array $singletons = [
        'files'     => Filesystem::class
    ];
}
