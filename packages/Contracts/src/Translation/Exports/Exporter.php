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
     * @param string|array $groups [optional] Groups to export. Wildcard (*) = all groups, incl. namespaced groups,
     *                             e.g. 'courier::messages'.
     *
     * @return mixed
     *
     * @throws ExporterException
     */
    public function export(
        string|array $locales = '*',
        string|array $groups = '*'
    ): mixed;

    /**
     * Detects the available locales
     *
     * @return string[]
     */
    public function detectLocals(): array;

    /**
     * Detect available groups
     *
     * @param bool $prefix [optional] When true, each group is prefixed with
     *                     the namespace it belongs to.
     *
     * @return string[] E.g. [ '*.auth', '*.pagination', ..., 'acme.users' ]
     */
    public function detectGroups(bool $prefix = true): array;

    /**
     * Get paths in which to search for translations
     *
     * @return string[]
     */
    public function getPaths(): array;
}
