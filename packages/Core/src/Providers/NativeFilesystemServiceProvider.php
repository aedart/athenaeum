<?php

namespace Aedart\Core\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

/**
 * Native Filesystem Service Provider
 *
 * Binds the "native" filesystem component
 *
 * @see \Illuminate\Filesystem\Filesystem
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class NativeFilesystemServiceProvider extends ServiceProvider
{
    /**
     * Singleton bindings
     *
     * @var array
     */
    public array $singletons = [
        'files' => Filesystem::class
    ];
}
