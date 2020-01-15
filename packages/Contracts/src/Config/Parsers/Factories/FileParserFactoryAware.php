<?php

namespace Aedart\Contracts\Config\Parsers\Factories;

/**
 * File Parser Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Config\Parsers\Factories
 */
interface FileParserFactoryAware
{
    /**
     * Set file parser factory
     *
     * @param FileParserFactory|null $factory File Parser Factory instance
     *
     * @return self
     */
    public function setFileParserFactory(?FileParserFactory $factory);

    /**
     * Get file parser factory
     *
     * If no file parser factory has been set, this method will
     * set and return a default file parser factory, if any such
     * value is available
     *
     * @see getDefaultFileParserFactory()
     *
     * @return FileParserFactory|null file parser factory or null if none file parser factory has been set
     */
    public function getFileParserFactory(): ?FileParserFactory;

    /**
     * Check if file parser factory has been set
     *
     * @return bool True if file parser factory has been set, false if not
     */
    public function hasFileParserFactory(): bool;

    /**
     * Get a default file parser factory value, if any is available
     *
     * @return FileParserFactory|null A default file parser factory value or Null if no default value is available
     */
    public function getDefaultFileParserFactory(): ?FileParserFactory;
}
