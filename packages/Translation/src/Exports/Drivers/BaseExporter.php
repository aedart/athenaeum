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
    public function export(
        string|array $locales = '*',
        string|array $groups = '*',
        string|array $namespaces = '*'
    ): mixed
    {
        $paths = $this->getPaths();
        if (empty($paths)) {
            throw new InvalidPaths('No paths provided');
        }

        $locales = $this->resolveLocales($locales);
        if (empty($locales)) {
            throw new InvalidLocales('No locales provided or unable to detect locales in paths');
        }

        $groups = $this->resolveGroups($groups);
        $namespaces = $this->resolveNamespaces($namespaces);

        try {
            return $this->performExport($paths, $locales, $groups, $namespaces);
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
     * @param string[] $paths Paths where to search for translations.
     * @param string[] $locales Locales to export.
     * @param string[] $groups Groups to export.
     * @param string[] $namespaces Namespaces to export.
     *
     * @return mixed
     *
     * @throws Throwable
     */
    abstract public function performExport(
        array $paths,
        array $locales,
        array $groups,
        array $namespaces
    ): mixed;

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
    public function detectGroups(bool $prefix = true): array
    {
        $paths = $this->getPaths();
        if (empty($paths)) {
            return [];
        }

        $namespaces = $this->getNamespacesWithPaths();

        // Filter off namespace paths to avoid evt. loading issues.
        $notNamespacedPaths = array_filter($paths, function($path) use($namespaces) {
            return !in_array($path, $namespaces);
        });

        // Groups found in paths, which are not namespaced must be prefixed
        // with wildcard (*).
        $output = $this->prefixGroups(
            groups: $this->findGroupsIn($notNamespacedPaths),
            prefix: $prefix
                ? '*.'
                : ''
        );

        // Groups found in paths with namespaces. These are prefixed with their
        // corresponding namespace.
        foreach ($namespaces as $namespace => $path) {
            // Skip if for some reason the namespace path isn't
            // part of the paths
            if (!in_array($path, $paths)) {
                continue;
            }

            $found = $this->prefixGroups(
                groups: $this->findGroupsIn([ $path ]),
                prefix: $prefix
                    ? $namespace . '.'
                    : ''
            );

            $output = array_merge($output, $found);
        }

        return $output;
    }

    /**
     * @inheritDoc
     */
    public function detectNamespaces(): array
    {
        // Wildcard acts as the "root" namespace
        return [
            '*',
            ...array_keys($this->getNamespacesWithPaths())
        ];
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
            ...array_values($this->getNamespacesWithPaths()),
            ...$this->options['paths'] ?? []
        ]);
    }

    /**
     * Get registered namespaces and their paths
     *
     * @return string[]
     */
    public function getNamespacesWithPaths(): array
    {
        return $this->getTranslationLoader()->namespaces();
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

    /**
     * Returns key in which json translations must be exported to
     *
     * @return string
     */
    public function jsonKey(): string
    {
        return $this->options['json_key'] ?? '__JSON__';
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
     * Resolves given groups
     *
     * @param string|string[] $groups
     *
     * @return string[]
     */
    protected function resolveGroups(string|array $groups): array
    {
        if ($groups === '*') {
            return $this->detectGroups();
        }

        if (is_string($groups)) {
            $groups = [ $groups ];
        }

        return $groups;
    }

    /**
     * Resolves given namespaces
     *
     * @param string|string[] $namespaces
     *
     * @return string[]
     */
    protected function resolveNamespaces(string|array $namespaces): array
    {
        if ($namespaces === '*') {
            return $this->detectNamespaces();
        }

        if (is_string($namespaces)) {
            $namespaces = [ $namespaces ];
        }

        return $namespaces;
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

    /**
     * Returns groups found in given paths
     *
     * @param string[] $paths
     *
     * @return string[]
     */
    protected function findGroupsIn(array $paths): array
    {
        $groups = [];

        // Normal language directory structure looks like this:
        // + en
        //     - messages.php
        // + es
        //     - messages.php
        // ...etc
        // @see https://laravel.com/docs/10.x/localization#introduction

        $found = Finder::create()
            ->files()
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->in($paths)
            ->depth(1)
            ->sortByName();

        foreach ($found as $item) {
            $groups[] = $item->getBasename('.' . $item->getExtension());
        }

        return array_unique($groups);
    }

    /**
     * Prefix each group
     *
     * @param string[] $groups
     * @param string $prefix [optional]
     *
     * @return string[]
     */
    protected function prefixGroups(array $groups, string $prefix = ''): array
    {
        if (empty($prefix) || empty($groups)){
            return $groups;
        }

        return array_map(function($group) use($prefix) {
            return $prefix . $group;
        }, $groups);
    }

    /**
     * Load translation messages that are defined in json files
     *
     * @param string[] $locales
     * @param string|null $key [optional]
     *
     * @return array
     */
    protected function loadJsonTranslations(array $locales, string|null $key = null): array
    {
        $loader = $this->getTranslationLoader();
        $key = $key ?? $this->jsonKey();

        $output = [];
        foreach ($locales as $locale) {
            if (!isset($output[$locale])) {
                $output[$locale] = [$key => []];
            }

            $output[$locale][$key] = array_merge_recursive(
                $output[$locale][$key],
                $loader->load($locale, '*', '*')
            );
        }

        return $output;
    }
}
