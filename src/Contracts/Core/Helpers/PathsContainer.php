<?php

namespace Aedart\Contracts\Core\Helpers;

use Aedart\Contracts\Support\Properties\Strings\BasePathAware;
use Aedart\Contracts\Support\Properties\Strings\BootstrapPathAware;
use Aedart\Contracts\Support\Properties\Strings\ConfigPathAware;
use Aedart\Contracts\Support\Properties\Strings\DatabasePathAware;
use Aedart\Contracts\Support\Properties\Strings\EnvironmentPathAware;
use Aedart\Contracts\Support\Properties\Strings\ResourcePathAware;
use Aedart\Contracts\Support\Properties\Strings\StoragePathAware;
use Aedart\Contracts\Utils\Populatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * Paths Container
 *
 * Keeps track of various application related paths
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core\Helpers
 */
interface PathsContainer extends BasePathAware,
    BootstrapPathAware,
    ConfigPathAware,
    DatabasePathAware,
    EnvironmentPathAware,
    ResourcePathAware,
    StoragePathAware,
    Populatable,
    Arrayable,
    Jsonable,
    JsonSerializable
{
    /**
     * Get a path within the "base" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function basePath(string $path = '') : string ;

    /**
     * Get a path within the "bootstrap" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function bootstrapPath(string $path = '') : string ;

    /**
     * Get a path within the "config" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function configPath(string $path = '') : string ;

    /**
     * get a path with the "database" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function databasePath(string $path = '') : string ;

    /**
     * Get a path within the "environment" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function environmentPath(string $path = '') : string ;

    /**
     * Get a path within the "resources" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function resourcePath(string $path = '') : string ;

    /**
     * Get a path within the "storage" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function storagePath(string $path = '') : string ;
}
