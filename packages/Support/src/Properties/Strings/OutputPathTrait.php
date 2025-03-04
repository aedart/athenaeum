<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Output path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\OutputPathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait OutputPathTrait
{
    /**
     * Location of where some kind of output must be placed or written to
     *
     * @var string|null
     */
    protected string|null $outputPath = null;

    /**
     * Set output path
     *
     * @param string|null $path Location of where some kind of output must be placed or written to
     *
     * @return self
     */
    public function setOutputPath(string|null $path): static
    {
        $this->outputPath = $path;

        return $this;
    }

    /**
     * Get output path
     *
     * If no output path value set, method
     * sets and returns a default output path.
     *
     * @see getDefaultOutputPath()
     *
     * @return string|null output path or null if no output path has been set
     */
    public function getOutputPath(): string|null
    {
        if (!$this->hasOutputPath()) {
            $this->setOutputPath($this->getDefaultOutputPath());
        }
        return $this->outputPath;
    }

    /**
     * Check if output path has been set
     *
     * @return bool True if output path has been set, false if not
     */
    public function hasOutputPath(): bool
    {
        return isset($this->outputPath);
    }

    /**
     * Get a default output path value, if any is available
     *
     * @return string|null Default output path value or null if no default value is available
     */
    public function getDefaultOutputPath(): string|null
    {
        return null;
    }
}
