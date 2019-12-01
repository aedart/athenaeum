<?php

namespace Aedart\Config\Facades;

use Aedart\Contracts\Config\Parsers\Factories\FileParserFactory as FileParserFactoryInterface;
use Aedart\Contracts\Config\Parsers\FileParser;
use Illuminate\Support\Facades\Facade;

/**
 * File Parser Factory
 *
 * @method FileParser make(string $type) Creates a new File Parser instance
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Facades
 */
class FileParserFactory extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return FileParserFactoryInterface::class;
    }
}
