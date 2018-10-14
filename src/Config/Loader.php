<?php

namespace Aedart\Config;


use Aedart\Config\Traits\FileParserFactoryTrait;
use Aedart\Contracts\Config\Loader as LoaderInterface;
use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Illuminate\Contracts\Config\Repository;

// TODO
class Loader implements LoaderInterface
{
    use ConfigTrait;
    use FileTrait;
    use FileParserFactoryTrait;

    /**
     * Set the path to where the configuration
     * files are located
     *
     * @param string $path
     *
     * @return self
     *
     * @throws InvalidPathException If given path does not exist
     */
    public function setDirectory(string $path): LoaderInterface
    {
        // TODO: Implement setDirectory() method.
    }

    /**
     * Returns the path to where the configuration
     * files are located
     *
     * @return string|null
     */
    public function getDirectory(): ?string
    {
        // TODO: Implement getDirectory() method.
    }

    /**
     * Check if a directory was set
     *
     * @return bool
     */
    public function hasDirectory(): bool
    {
        // TODO: Implement hasDirectory() method.
    }

    /**
     * Loads and parses the configuration files found inside
     * the specified directory
     *
     * @see getDirectory()
     * @see parse()
     * @see getConfig()
     *
     * @throws FileParserException If unable to parse a given configuration file
     * @throws InvalidPathException If no directory was specified
     */
    public function load(): void
    {
        // TODO: Implement load() method.
    }

    /**
     * Parse the given configuration file, and return instance
     * of the repository, in which the configuration is contained
     *
     * @param string $filePath Path to configuration file
     *
     * @return Repository
     *
     * @throws FileParserException If unable to parse given configuration file
     */
    public function parse(string $filePath): Repository
    {
        // TODO: Implement parse() method.
    }
}
