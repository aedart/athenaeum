<?php

namespace Aedart\Translation\Exports\Drivers;

use Aedart\Utils\Json;

/**
 * Lang.js (Json) Exporter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
class LangJsJsonExporter extends BaseExporter
{
    use Concerns\LangJsFormatting;

    /**
     * @inheritDoc
     */
    public function performExport(array $paths, array $locales, array $groups): string
    {
        $translations = $this->format(
            $this->load($locales, $groups)
        );

        return Json::encode(
            value: $translations,
            options: $this->jsonOptions(),
            depth: $this->jsonDepth()
        );
    }

    /**
     * Returns JSON encoding options
     *
     * @return int
     */
    public function jsonOptions(): int
    {
        return $this->options['json_options'] ?? 0;
    }

    /**
     * Returns JSON maximum depth
     *
     * @return int
     */
    public function jsonDepth(): int
    {
        return $this->options['depth'] ?? 512;
    }
}
