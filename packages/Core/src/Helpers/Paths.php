<?php

namespace Aedart\Core\Helpers;

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Dto\Dto;
use Aedart\Support\Properties\Strings\BasePathTrait;
use Aedart\Support\Properties\Strings\BootstrapPathTrait;
use Aedart\Support\Properties\Strings\ConfigPathTrait;
use Aedart\Support\Properties\Strings\DatabasePathTrait;
use Aedart\Support\Properties\Strings\EnvironmentPathTrait;
use Aedart\Support\Properties\Strings\LangPathTrait;
use Aedart\Support\Properties\Strings\PublicPathTrait;
use Aedart\Support\Properties\Strings\ResourcePathTrait;
use Aedart\Support\Properties\Strings\StoragePathTrait;

/**
 * Paths Container
 *
 * @see \Aedart\Contracts\Core\Helpers\PathsContainer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Helpers
 */
class Paths extends Dto implements PathsContainer
{
    use BasePathTrait;
    use BootstrapPathTrait;
    use ConfigPathTrait;
    use LangPathTrait;
    use DatabasePathTrait;
    use EnvironmentPathTrait;
    use ResourcePathTrait;
    use StoragePathTrait;
    use PublicPathTrait;

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
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultBasePath(): string|null
    {
        return getcwd();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultBootstrapPath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'bootstrap';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultConfigPath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * @inheritDoc
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
     * @inheritdoc
     */
    public function getDefaultDatabasePath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'database';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultEnvironmentPath(): string|null
    {
        return $this->getBasePath();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultResourcePath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'resources';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultStoragePath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'storage';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultPublicPath(): string|null
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'public';
    }
}
