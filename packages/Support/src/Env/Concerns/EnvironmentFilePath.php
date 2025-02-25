<?php

namespace Aedart\Support\Env\Concerns;

use Illuminate\Support\Facades\App;

/**
 * Concerns Environment File Path
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Env\Concerns
 */
trait EnvironmentFilePath
{
    /**
     * Path to environment file
     *
     * @var string|null
     */
    protected string|null $environmentFilePath = null;

    /**
     * Set environment file path
     *
     * @param string|null $path Path to environment file
     *
     * @return self
     */
    public function setEnvironmentFilePath(string|null $path): static
    {
        $this->environmentFilePath = $path;

        return $this;
    }

    /**
     * Get environment file path
     *
     * @return string|null
     */
    public function getEnvironmentFilePath(): string|null
    {
        if (!$this->hasEnvironmentFilePath()) {
            $this->setEnvironmentFilePath($this->getDefaultEnvironmentFilePath());
        }
        return $this->environmentFilePath;
    }

    /**
     * Check if environment file path has been set
     *
     * @return bool
     */
    public function hasEnvironmentFilePath(): bool
    {
        return isset($this->environmentFilePath);
    }

    /**
     * Get a default environment file path value, if any is available
     *
     * @return string|null
     */
    public function getDefaultEnvironmentFilePath(): string|null
    {
        return App::environmentFilePath();
    }
}
