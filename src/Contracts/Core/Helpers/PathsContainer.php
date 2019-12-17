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

}
