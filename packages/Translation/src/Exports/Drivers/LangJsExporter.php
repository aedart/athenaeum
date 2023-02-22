<?php

namespace Aedart\Translation\Exports\Drivers;

/**
 * Lang JS Exporter
 *
 * @see https://github.com/rmariuzzo/Lang.js
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
class LangJsExporter extends BaseExporter
{
    /**
     * @inheritDoc
     */
    public function performExport(array $paths, array $locales, array $groups): array
    {
        return $this->format(
            $this->load($locales, $groups)
        );
    }

    /**
     * Formats translations acc. to Lang.js source format
     *
     * @see https://github.com/rmariuzzo/Lang.js#messages-source-format
     *
     * @param array $translations
     *
     * @return array
     */
    protected function format(array $translations): array
    {
        $output = [];
        foreach ($translations as $locale => $groups) {
            foreach ($groups as $group => $items) {

                // Ensure locale / group key exists.
                $key = "{$locale}.$group";
                if (!isset($output[$key])) {
                    $output[$key] = [];
                }

                $output[$key] = array_merge_recursive(
                    $output[$key],
                    $items
                );
            }
        }

        return $output;
    }
}
