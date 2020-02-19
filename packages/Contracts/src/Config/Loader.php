<?php

namespace Aedart\Contracts\Config;

use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Contracts\Config\Parsers\Factories\FileParserFactoryAware;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Contracts\Support\Helpers\Filesystem\FileAware;
use Illuminate\Contracts\Config\Repository;
use SplFileInfo;

/**
 * Configuration Loader
 *
 * <br />
 *
 * Responsible for loading and parsing various types of configuration files.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Config
 */
interface Loader extends ConfigAware,
    FileAware,
    FileParserFactoryAware
{
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
    public function setDirectory(string $path): self;

    /**
     * Returns the path to where the configuration
     * files are located
     *
     * @return string|null
     */
    public function getDirectory(): ?string;

    /**
     * Check if a directory was set
     *
     * @return bool
     */
    public function hasDirectory(): bool;

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
    public function load(): void;

    /**
     * Parse the given configuration file, and return instance
     * of the repository, in which the configuration is contained
     *
     * @param string|SplFileInfo $file File path or SplFileInfo
     *
     * @return Repository
     *
     * @throws FileParserException If unable to parse given configuration file
     */
    public function parse($file): Repository;
}
