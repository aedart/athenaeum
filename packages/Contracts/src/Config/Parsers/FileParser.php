<?php

namespace Aedart\Contracts\Config\Parsers;

use Aedart\Contracts\Config\Parsers\Exceptions\FileDoesNotExistException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Contracts\Support\Helpers\Filesystem\FileAware;

/**
 * Configuration File Parser
 *
 * <br />
 *
 * Responsible for parsing a given file into a php array.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Config\Parsers
 */
interface FileParser extends FileAware
{
    /**
     * Returns the file extension that this parser
     * is responsible for parsing
     *
     * @return string E.g. ini, php, yml... etc
     */
    public static function getFileType(): string;

    /**
     * Set the path of the configuration file that
     * needs to be parsed by this parser
     *
     * @param string $filePath
     *
     * @return self
     *
     * @throws FileDoesNotExistException If the given file does not exist
     */
    public function setFilePath(string $filePath): self;

    /**
     * Get the path of the configuration file that
     * needs to be parsed by this parser
     *
     * @return string|null
     */
    public function getFilePath(): ?string;

    /**
     * Check if this parser has a configuration file path
     * set or not
     *
     * @return bool
     */
    public function hasFilePath(): bool;

    /**
     * Loads the specified configuration file's content
     * and parses it to an array
     *
     * @return array Key value pair
     *
     * @see parse()
     *
     * @throws FileParserException If given file's content could not be parsed
     */
    public function loadAndParse(): array;

    /**
     * Parse the given content into an array
     *
     * @param string $content
     *
     * @return array
     *
     * @throws FileParserException If given content could not be parsed
     */
    public function parse(string $content): array;
}
