<?php

namespace Aedart\Core\Helpers;

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Dto\ArrayDto;

/**
 * Paths Container
 *
 * @see \Aedart\Contracts\Core\Helpers\PathsContainer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Helpers
 */
class Paths extends ArrayDto implements PathsContainer
{
    /**
     * Defines the allowed properties and their
     * data type.
     *
     * @type array<string, string>
     */
    protected array $allowed = [
        'basePath' => 'string',
        'bootstrapPath' => 'string',
        'configPath' => 'string',
        'langPath' => 'string',
        'databasePath' => 'string',
        'environmentPath' => 'string',
        'resourcePath' => 'string',
        'storagePath' => 'string',
        'publicPath' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function basePath(string $path = ''): string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function bootstrapPath(string $path = ''): string
    {
        return $this->getBootstrapPath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function configPath(string $path = ''): string
    {
        return $this->getConfigPath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function langPath(string $path = ''): string
    {
        return $this->getLangPath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function databasePath(string $path = ''): string
    {
        return $this->getDatabasePath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function environmentPath(string $path = ''): string
    {
        return $this->getEnvironmentPath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function resourcePath(string $path = ''): string
    {
        return $this->getResourcePath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function storagePath(string $path = ''): string
    {
        return $this->getStoragePath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @inheritDoc
     */
    public function publicPath(string $path = ''): string
    {
        return $this->getPublicPath() . DIRECTORY_SEPARATOR . $path;
    }

    /*****************************************************************
     * Accessors
     ****************************************************************/

    /**
     * Get the base directory path
     *
     * @return string|null
     */
    public function getBasePath(): string|null
    {
        return $this->properties['basePath'] ?? $this->getDefaultBasePath();
    }

    /**
     * Get a default base directory path
     *
     * @return string|null
     */
    public function getDefaultBasePath(): string|null
    {
        return getcwd();
    }

    /**
     * Get the bootstrap directory path
     *
     * @return string|null
     */
    public function getBootstrapPath(): string|null
    {
        return $this->properties['bootstrapPath'] ?? $this->getDefaultBootstrapPath();
    }

    /**
     * Get a default bootstrap directory path
     *
     * @return string|null
     */
    public function getDefaultBootstrapPath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'bootstrap';
    }

    /**
     * Get config directory path
     *
     * @return string|null
     */
    public function getConfigPath(): string|null
    {
        return $this->properties['configPath'] ?? $this->getDefaultConfigPath();
    }

    /**
     * Get a default config directory path
     *
     * @return string|null
     */
    public function getDefaultConfigPath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * Get lang directory path
     *
     * @return string|null
     */
    public function getLangPath(): string|null
    {
        return $this->properties['langPath'] ?? $this->getDefaultLangPath();
    }

    /**
     * Ge a default lang directory path
     *
     * @return string|null
     */
    public function getDefaultLangPath(): string|null
    {
        // If a "lang" directory already exists in the resource path,
        // then use it. This is to ensure that we do not break backwards
        // compatibility with previous version (pre v6.x).
        // This is pretty much the same logic as Laravel v9.x uses.
        $dir = $this->resourcePath('lang');
        if (is_dir($dir)) {
            return $dir;
        }

        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'lang';
    }

    /**
     * Get database directory path
     *
     * @return string|null
     */
    public function getDatabasePath(): string|null
    {
        return $this->properties['databasePath'] ?? $this->getDefaultDatabasePath();
    }

    /**
     * Get a default database directory path
     *
     * @return string|null
     */
    public function getDefaultDatabasePath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'database';
    }

    /**
     * Get environment directory path
     *
     * @return string|null
     */
    public function getEnvironmentPath(): string|null
    {
        return $this->properties['environmentPath'] ?? $this->getDefaultEnvironmentPath();
    }

    /**
     * Get a default environment directory path
     *
     * @return string|null
     */
    public function getDefaultEnvironmentPath(): string|null
    {
        return $this->getBasePath();
    }

    /**
     * Get resource directory path
     *
     * @return string|null
     */
    public function getResourcePath(): string|null
    {
        return $this->properties['resourcePath'] ?? $this->getDefaultResourcePath();
    }

    /**
     * Get a default resource directory path
     *
     * @return string|null
     */
    public function getDefaultResourcePath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'resources';
    }

    /**
     * Get storage directory path
     *
     * @return string|null
     */
    public function getStoragePath(): string|null
    {
        return $this->properties['storagePath'] ?? $this->getDefaultStoragePath();
    }

    /**
     * Get a default storage directory path
     *
     * @return string|null
     */
    public function getDefaultStoragePath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'storage';
    }

    /**
     * Get public directory path
     *
     * @return string|null
     */
    public function getPublicPath(): string|null
    {
        return $this->properties['publicPath'] ?? $this->getDefaultPublicPath();
    }

    /**
     * Get a default public directory path
     *
     * @return string|null
     */
    public function getDefaultPublicPath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'public';
    }
}
