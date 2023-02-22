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
    ): array {
        return $this->load($locales, $groups);
    }
}
