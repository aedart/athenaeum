<?php

namespace Aedart\Translation\Exports\Drivers;

/**
 * Lang.js (Array) Exporter
 *
 * @see https://github.com/rmariuzzo/Lang.js
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
class LangJsExporter extends BaseExporter
{
    use Concerns\LangJsFormatting;

    /**
     * @inheritDoc
     */
    public function performExport(array $paths, array $locales, array $groups): array
    {
        return $this->format(
            $this->load($locales, $groups)
        );
    }
}
