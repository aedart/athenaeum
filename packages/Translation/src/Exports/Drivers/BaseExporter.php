<?php

namespace Aedart\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Support\Helpers\Translation\TranslationLoaderTrait;
use Aedart\Translation\Exports\Exceptions\FailedToExportTranslations;
use Aedart\Translation\Exports\Exceptions\InvalidLocales;
use Aedart\Translation\Exports\Exceptions\InvalidPaths;
use Illuminate\Contracts\Translation\Loader;
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
    use Concerns\Prefixing;
    use Concerns\Detection;

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
        string|array $groups = '*'
    ): mixed {
        $paths = $this->getPaths();
        if (empty($paths)) {
            throw new InvalidPaths('No paths provided');
        }

        $locales = $this->resolveLocales($locales, $paths);
        if (empty($locales)) {
            throw new InvalidLocales('No locales provided or unable to detect locales in paths');
        }

        $groups = $this->resolveGroups($groups, $paths);

        try {
            return $this->performExport($paths, $locales, $groups);
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
     *
     * @return mixed
     *
     * @throws Throwable
     */
    abstract public function performExport(
        array $paths,
        array $locales,
        array $groups
    ): mixed;

    /**
     * @inheritDoc
     */
    public function detectLocals(array|null $paths = null): array
    {
        $paths = $paths ?? $this->getPaths();
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
    public function detectGroups(array|null $paths = null, bool $prefix = true): array
    {
        $paths = $paths ?? $this->getPaths();
        if (empty($paths)) {
            return [];
        }

        $namespaces = $this->getNamespacesWithPaths();

        // Filter off namespace paths to avoid evt. loading issues.
        $notNamespacedPaths = array_filter($paths, function ($path) use ($namespaces) {
            return !in_array($path, $namespaces);
        });

        // Groups found in paths, which are not namespaced must be prefixed
        // with wildcard (*).
        $output = $this->prefixGroups(
            groups: $this->detectGroupsIn($notNamespacedPaths),
            namespace: $prefix
                ? '*'
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
                groups: $this->detectGroupsIn([ $path ]),
                namespace: $prefix
                    ? $namespace
                    : ''
            );

            $output = array_merge($output, $found);
        }

        return $output;
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
     * @param string[]|null $paths [optional] Paths in which to detect locales, when wildcard given.
     *
     * @return string[]
     */
    protected function resolveLocales(string|array $locales, array|null $paths = null): array
    {
        if ($locales === '*') {
            return $this->detectLocals($paths);
        }

        if (is_string($locales)) {
            $locales = [ $locales ];
        }

        return array_unique($locales);
    }

    /**
     * Resolves given groups
     *
     * @param string|string[] $groups
     * @param string[]|null $paths [optional] Paths in which to detect groups, when wildcard given.
     *
     * @return string[]
     */
    protected function resolveGroups(string|array $groups, array|null $paths = null): array
    {
        if ($groups === '*') {
            return $this->detectGroups($paths);
        }

        if (is_string($groups)) {
            $groups = [ $groups ];
        }

        return array_unique($groups);
    }

    /**
     * Loads translations belonging to given locales and groups.
     *
     * **Caution**: _Method relies on assigned {@see Loader} to perform
     * the heavy lifting, handle vendor overwrites, etc.
     * This also means that if requested namespaced groups are not known
     * by the loader, then they will not be loaded!_
     *
     * @param string[] $locales
     * @param string[] $groups
     *
     * @return array
     */
    protected function load(
        array $locales,
        array $groups
    ): array {
        // Load json translations that match requested locales
        $json = $this->loadJsonTranslations($locales);

        // Load groups' translations (including evt. namespaced groups)
        $translations = $this->loadTranslationsForGroups($locales, $groups);

        // Finally, merge the translations together
        return array_merge_recursive(
            $json,
            $translations
        );
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

    /**
     * Loads translation messages belonging to locales and groups
     *
     * @param string[] $locales
     * @param string[] $groups
     *
     * @return array
     */
    protected function loadTranslationsForGroups(array $locales, array $groups): array
    {
        $output = [];
        foreach ($locales as $locale) {
            if (!isset($output[$locale])) {
                $output[$locale] = [];
            }

            foreach ($groups as $group) {
                $translations = $this->loadGroupTranslations($locale, $group);
                if (empty($translations)) {
                    continue;
                }

                $output[$locale][$this->removeWildcardPrefix($group)] = $translations;
            }
        }

        return $output;
    }

    /**
     * Loads translation messages belonging to locale and group
     *
     * @param string $locale
     * @param string $group
     *
     * @return array
     */
    protected function loadGroupTranslations(string $locale, string $group): array
    {
        // Ensure that group is prefixed with a namespace, so it can treat uniformly...
        $separator = $this->prefixSeparator();
        if (!str_contains($group, $separator)) {
            $group = $this->prefixGroup($group, '*');
        }

        // Extract namespace from group and load the translation lines
        // via the loader.
        [$namespace, $group] = explode($separator, $group, 2);

        return $this->getTranslationLoader()->load($locale, $group, $namespace);
    }
}
