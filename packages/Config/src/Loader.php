<?php

namespace Aedart\Config;

use Aedart\Config\Loaders\Exceptions\InvalidPath;
use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Aedart\Config\Traits\FileParserFactoryTrait;
use Aedart\Contracts\Config\Loader as LoaderInterface;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Illuminate\Contracts\Config\Repository;
use SplFileInfo;
use Throwable;

/**
 * Configuration Loader
 *
 * @see \Aedart\Contracts\Config\Loader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config
 */
class Loader implements LoaderInterface
{
    use ConfigTrait;
    use FileTrait;
    use FileParserFactoryTrait;

    /**
     * Directory location of configuration files
     *
     * @var null|string
     */
    protected string|null $directory = null;

    /**
     * {@inheritdoc}
     */
    public function setDirectory(string $path): static
    {
        $path = realpath($path);

        if (!is_dir($path)) {
            throw new InvalidPath(sprintf('%s does not exist', $path));
        }

        if (substr($path, -1) !== DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }

        $this->directory = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectory(): string|null
    {
        return $this->directory;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDirectory(): bool
    {
        return isset($this->directory);
    }

    /**
     * {@inheritdoc}
     */
    public function load(): void
    {
        if (!$this->hasDirectory()) {
            throw new InvalidPath('Unable to load configuration. No load directory specified');
        }

        $files = $this->getFile()->allFiles($this->getDirectory());
        foreach ($files as $fileInfo) {
            $this->parse($fileInfo->getRealPath());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parse(SplFileInfo|string $file): Repository
    {
        $file = $this->resolveFile($file);

        try {
            // Get the file path
            $path = $file->getRealPath();

            // Obtain a parser for the given file ext.
            $parser = $this->getFileParserFactory()->make($file->getExtension());
            $parser->setFile($this->getFile());

            // Load and parse the file content
            $content = $parser
                ->setFilePath($path)
                ->loadAndParse();

            // Merge content into configuration. We do not
            // simply want to "overwrite" entire config.
            $config = $this->getConfig();

            $section = $this->resolveSectionName($file, $this->getDirectory());
            $existing = $config->get($section, []);
            $new = array_merge($existing, $content);

            $config->set($section, $new);
            return $config;
        } catch (Throwable $e) {
            throw new UnableToParseFile(sprintf('Unable to parse file %s: %s', (string) $file, $e->getMessage()), $e->getCode(), $e);
        }
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve the given file into a SplFileInfo obj
     *
     * @param  SplFileInfo|string  $file
     *
     * @return SplFileInfo
     */
    protected function resolveFile(SplFileInfo|string $file): SplFileInfo
    {
        if ($file instanceof SplFileInfo) {
            return $file;
        }

        return new SplFileInfo($file);
    }

    /**
     * Resolves the section name of configuration
     *
     * @param SplFileInfo $file
     * @param string $directory
     *
     * @return string
     */
    protected function resolveSectionName(SplFileInfo $file, string $directory): string
    {
        $path = str_replace($directory, '', $file->getPath() . DIRECTORY_SEPARATOR) . $file->getBasename('.' . $file->getExtension());

        return strtolower(str_replace(DIRECTORY_SEPARATOR, '.', $path));
    }
}
