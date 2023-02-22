<?php

namespace Aedart\Contracts\Translation\Exports;

use Aedart\Contracts\Support\Helpers\Translation\TranslationLoaderAware;
use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;

/**
 * Translations Exporter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Translation\Exports
 */
interface Exporter extends TranslationLoaderAware
{
    /**
     * Export translations
     *
     * @param string|array $locales [optional] Locales to export. Wildcard (*) = all locales.
     * @param string|array $groups [optional] Groups to export. Wildcard (*) = all groups.
     * @param string|array $namespaces [optional] Namespaces to export. Wildcard (*) = all namespaces.
     *
     * @return mixed
     *
     * @throws ExporterException
     */
    public function export(
        string|array $locales = '*',
        string|array $groups = '*',
        string|array $namespaces = '*'
    ): mixed;

    /**
     * Detects the available locales
     *
     * @return string[]
     */
    public function detectLocals(): array;

    /**
     * Detects available groups
     *
     * @return string[]
     */
    public function detectGroups(): array;

    /**
     * Detect available namespaces
     *
     * @return string[]
     */
    public function detectNamespaces(): array;

    /**
     * Get paths in which to search for translations
     *
     * @return string[]
     */
    public function getPaths(): array;
}
