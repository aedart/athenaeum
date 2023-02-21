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
     * @param string|string[] $locales [optional] Locales to export. When wildcard is provided,
     *                                 then all available locales are exported.
     *
     * @return mixed
     *
     * @throws ExporterException
     */
    public function export(string|array $locales = '*'): mixed;

    /**
     * Detects the available locales
     *
     * @return string[]
     */
    public function detectLocals(): array;

    /**
     * Get paths to be searched
     *
     * @return string[]
     */
    public function getPaths(): array;
}