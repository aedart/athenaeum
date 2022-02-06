<?php

namespace Aedart\Config\Traits;

use Aedart\Config\Facades\FileParserFactory as FileParserFactoryFacade;
use Aedart\Contracts\Config\Parsers\Factories\FileParserFactory;

/**
 * File Parser Factory Trait
 *
 * @see \Aedart\Contracts\Config\Parsers\Factories\FileParserFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Traits
 */
trait FileParserFactoryTrait
{
    /**
     * File Parser Factory instance
     *
     * @var FileParserFactory|null
     */
    protected FileParserFactory|null $fileParserFactory = null;

    /**
     * Set file parser factory
     *
     * @param FileParserFactory|null $factory File Parser Factory instance
     *
     * @return self
     */
    public function setFileParserFactory(FileParserFactory|null $factory): static
    {
        $this->fileParserFactory = $factory;

        return $this;
    }

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
    public function getFileParserFactory(): FileParserFactory|null
    {
        if (!$this->hasFileParserFactory()) {
            $this->setFileParserFactory($this->getDefaultFileParserFactory());
        }
        return $this->fileParserFactory;
    }

    /**
     * Check if file parser factory has been set
     *
     * @return bool True if file parser factory has been set, false if not
     */
    public function hasFileParserFactory(): bool
    {
        return isset($this->fileParserFactory);
    }

    /**
     * Get a default file parser factory value, if any is available
     *
     * @return FileParserFactory|null A default file parser factory value or Null if no default value is available
     */
    public function getDefaultFileParserFactory(): FileParserFactory|null
    {
        return FileParserFactoryFacade::getFacadeRoot();
    }
}
