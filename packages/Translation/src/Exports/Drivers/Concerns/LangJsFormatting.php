<?php

namespace Aedart\Translation\Exports\Drivers\Concerns;

/**
 * Lang.js Formatting
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers\Concerns
 */
trait LangJsFormatting
{
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
