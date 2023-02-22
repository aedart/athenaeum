<?php

namespace Aedart\Translation\Exports\Drivers;

/**
 * Array Exporter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
class ArrayExporter extends BaseExporter
{
    /**
     * @inheritDoc
     */
    public function performExport(
        array $paths,
        array $locales,
        array $groups
    ): array
    {
        // 1) Load json translations that match requested locales
        $json = $this->loadJsonTranslations($locales);

        // 2) Load groups' translations (including evt. namespaced groups)
        $translations = $this->loadTranslationsForGroups($locales, $groups);

        // 3) Finally, merge the translations together
        return array_merge_recursive(
            $json,
            $translations
        );
    }
}
