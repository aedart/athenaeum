<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use League\Flysystem\PathPrefixer;

/**
 * Concerns Path Prefixing
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait PathPrefixing
{
    /**
     * Path prefixer
     *
     * @var PathPrefixer
     */
    protected PathPrefixer $prefixer;

    /**
     * Set path prefix
     *
     * @param string $prefix
     *
     * @return self
     */
    public function setPathPrefix(string $prefix): static
    {
        return $this->setPrefixer(
            new PathPrefixer($prefix)
        );
    }

    /**
     * Set path prefixer instance
     *
     * When invoking this method,
     *
     * @param PathPrefixer $prefixer
     *
     * @return self
     */
    public function setPrefixer(PathPrefixer $prefixer): static
    {
        $this->prefixer = $prefixer;

        return $this;
    }

    /**
     * Get path prefixer instance
     *
     * @return PathPrefixer
     */
    public function getPrefixer(): PathPrefixer
    {
        return $this->prefixer;
    }

    /**
     * Applies path prefix for given path
     *
     * @see stripPrefix
     *
     * @param string $path
     *
     * @return string Prefixed path
     */
    public function applyPrefix(string $path): string
    {
        return $this->getPrefixer()->prefixPath($path);
    }

    /**
     * Strips path prefix from given path
     *
     * @see applyPrefix
     *
     * @param string $path
     *
     * @return string Path without prefix
     */
    public function stripPrefix(string $path): string
    {
        return $this->getPrefixer()->stripPrefix($path);
    }
}