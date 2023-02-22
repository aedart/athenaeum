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
        array $groups,
        array $namespaces
    ): array
    {
        // 1) Load json translations that match requested locales
        $json = $this->loadJsonTranslations($locales);

        // 2) Detect "groups"... or is it namespaces, from given paths ???

        // 3 Load all "groups / name-thingies"

        // 4 Namespaces... ??

        // TODO: Incomplete...
        return array_merge_recursive(
            $json
        );
    }
}
