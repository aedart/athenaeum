<?php

namespace Aedart\Config\Facades;

use Aedart\Contracts\Config\Loader;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Facade;

/**
 * Config Loader Facade
 *
 * @method Loader setDirectory(string $path)
 * @method string|null getDirectory()
 * @method bool hasDirectory()
 * @method void load()
 * @method Repository parse(string $filePath)
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Facades
 */
class ConfigLoader extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return Loader::class;
    }
}
