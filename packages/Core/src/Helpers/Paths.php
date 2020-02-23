<?php

namespace Aedart\Core\Helpers;

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Dto\Dto;
use Aedart\Support\Properties\Strings\BasePathTrait;
use Aedart\Support\Properties\Strings\BootstrapPathTrait;
use Aedart\Support\Properties\Strings\ConfigPathTrait;
use Aedart\Support\Properties\Strings\DatabasePathTrait;
use Aedart\Support\Properties\Strings\EnvironmentPathTrait;
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
    public function getDefaultBasePath(): ?string
    {
        return getcwd();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultBootstrapPath(): ?string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'bootstrap';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultConfigPath(): ?string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDatabasePath(): ?string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'database';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultEnvironmentPath(): ?string
    {
        return $this->getBasePath();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultResourcePath(): ?string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'resources';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultStoragePath(): ?string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'storage';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultPublicPath(): ?string
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'public';
    }
}
