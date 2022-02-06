<?php

namespace Aedart\Config\Parsers\Factories;

use Aedart\Config\Parsers\Exceptions\NoFileParserFound;
use Aedart\Config\Parsers\Files\Ini;
use Aedart\Config\Parsers\Files\Json;
use Aedart\Config\Parsers\Files\PhpArray;
use Aedart\Config\Parsers\Files\Toml;
use Aedart\Config\Parsers\Files\Yaml;
use Aedart\Contracts\Config\Parsers\Factories\FileParserFactory as FileParserFactoryInterface;
use Aedart\Contracts\Config\Parsers\FileParser;

/**
 * File Parser Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Factories
 */
class FileParserFactory implements FileParserFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function make(string $type): FileParser
    {
        $type = strtolower(trim($type));

        return match ($type) {
            PhpArray::getFileType() => new PhpArray(),
            Json::getFileType() => new Json(),
            Ini::getFileType() => new Ini(),
            Yaml::getFileType() => new Yaml(),
            Toml::getFileType() => new Toml(),
            default => throw new NoFileParserFound(sprintf('No parser found for "%s"', $type))
        };
    }
}
