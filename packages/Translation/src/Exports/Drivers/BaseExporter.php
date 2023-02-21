<?php

namespace Aedart\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Support\Helpers\Translation\TranslationLoaderTrait;
use Aedart\Translation\Exports\Exceptions\FailedToExportTranslations;
use Aedart\Translation\Exports\Exceptions\InvalidLocales;
use Aedart\Translation\Exports\Exceptions\InvalidPaths;
use Illuminate\Contracts\Translation\Loader;
use Symfony\Component\Finder\Finder;
use Throwable;

/**
 * Base Exporter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
abstract class BaseExporter implements Exporter
{
    use TranslationLoaderTrait;

    /**
     * Creates a new translations exporter instance
     *
     * @param Loader|null $loader [optional]
     * @param array $options [optional]
     */
    public function __construct(
        Loader|null $loader = null,
        protected array $options = []
    ) {
        $this->setTranslationLoader($loader);
    }

    /**
     * @inheritDoc
     */
    public function export(string|array $locales = '*'): mixed
    {
        $locales = $this->resolveLocales($locales);
        $paths = $this->getPaths();

        if (empty($paths)) {
            throw new InvalidPaths('No paths provided');
        }

        if (empty($locales)) {
            throw new InvalidLocales('No locales provided or unable to detect locales in paths');
        }

        try {
            return $this->performExport($locales, $paths);
        } catch (Throwable $e) {
            throw new FailedToExportTranslations(sprintf(
                'Unable to export locales %s: %s',
                implode(', ', $locales),
                $e->getMessage()
            ), $e->getCode(), $e);
        }
    }

    /**
     * Searches for translations and exports them
     *
     * @param string[] $locales Locales to export
     * @param string[] $paths Paths where to search for translations
     *
     * @return mixed
     */
    abstract public function performExport(array $locales, array $paths): mixed;

    /**
     * @inheritDoc
     */
    public function detectLocals(): array
    {
        $paths = $this->getPaths();
        if (empty($paths)) {
            return [];
        }

        return array_unique([
            ...$this->detectLocalesFromDirectories($paths),
            ...$this->detectLocalesFromJsonFilesIn($paths)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getPaths(): array
    {
        // To ensure that all relevant paths are returned, the user
        // provided paths must be merged with those from the native
        // translation loader.

        return array_unique([
            ...$this->getJsonPaths(),
            ...$this->getNamespacePaths(),
            ...$this->options['paths'] ?? []
        ]);
    }

    /**
     * Get registered "namespace" paths
     *
     * @return string[]
     */
    public function getNamespacePaths(): array
    {
        return array_values($this->getTranslationLoader()->namespaces());
    }

    /**
     * Get registered json paths
     *
     * @return string[]
     */
    public function getJsonPaths(): array
    {
        $nativeLoader = $this->getTranslationLoader();

        if (!method_exists($nativeLoader, 'jsonPaths')) {
            return [];
        }

        return array_values($nativeLoader->jsonPaths());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves given locales
     *
     * @param string|string[] $locales
     *
     * @return string[]
     */
    protected function resolveLocales(string|array $locales): array
    {
        if ($locales === '*') {
            return $this->detectLocals();
        }

        if (is_string($locales)) {
            $locales = [ $locales ];
        }

        return $locales;
    }

    /**
     * Detect locales from the names of the directories found in given paths
     *
     * @param string[] $paths
     *
     * @return string[] E.g. en, en-uk, fr, da... etc
     */
    protected function detectLocalesFromDirectories(array $paths): array
    {
        $locales = [];

        $found = Finder::create()
            ->in($paths)
            ->directories()
            ->depth(0)
            ->sortByName();

        foreach ($found as $item) {
            $locales[] = $item->getBasename();
        }

        return array_unique($locales);
    }

    /**
     * Detect locales from the json files' names in given paths
     *
     * @param string[] $paths
     *
     * @return string[] E.g. en, en-uk, fr, da... etc
     */
    protected function detectLocalesFromJsonFilesIn(array $paths): array
    {
        $locales = [];

        $found = Finder::create()
            ->files()
            ->name('*.json')
            ->ignoreDotFiles(true)
            ->in($paths)
            ->depth(0)
            ->sortByName();

        foreach ($found as $item) {
            $locales[] = $item->getBasename('.' . $item->getExtension());
        }

        return array_unique($locales);
    }
}
