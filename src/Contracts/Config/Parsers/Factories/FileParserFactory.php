<?php

namespace Aedart\Contracts\Config\Parsers\Factories;

use Aedart\Contracts\Config\Parsers\Exceptions\NoFileParserFoundException;
use Aedart\Contracts\Config\Parsers\FileParser;

/**
 * File Parser Factory
 *
 * <br />
 *
 * Responsible for creating File Parser instances.
 *
 * @see \Aedart\Contracts\Config\Parsers\FileParser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Config\Parsers\Factories
 */
interface FileParserFactory
{
    /**
     * Creates a new File Parser instance, based on the given type
     *
     * @param string $type
     *
     * @return FileParser
     *
     * @throws NoFileParserFoundException
     */
    public function make(string $type) : FileParser ;
}
