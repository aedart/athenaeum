<?php

namespace Aedart\Config\Parsers\Factories;

use Aedart\Config\Parsers\Exceptions\NoFileParserFound;
use Aedart\Config\Parsers\Files\Ini;
use Aedart\Config\Parsers\Files\Json;
use Aedart\Config\Parsers\Files\PhpArray;
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
        switch ($type) {

            case PhpArray::getFileType():
                return new PhpArray();
                break;

            case Json::getFileType():
                return new Json();
                break;

            case Ini::getFileType():
                return new Ini();
                break;

            case Yaml::getFileType():
            case 'yaml':
                return new Yaml();
                break;

            default:
                throw new NoFileParserFound(sprintf('No parser found for "%s"', $type));
                break;
        }
    }
}
