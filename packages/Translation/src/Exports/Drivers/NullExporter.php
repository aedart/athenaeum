<?php

namespace Aedart\Translation\Exports\Drivers;

/**
 * Null Exporter
 *
 * Intended for testing or situation when an exporter is
 * required, yet not intended to do anything.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
class NullExporter extends BaseExporter
{
    /**
     * @inheritDoc
     */
    public function performExport(
        array $paths,
        array $locales,
        array $groups
    ): mixed {
        return null;
    }
}
