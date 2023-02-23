<?php

namespace Aedart\Translation\Exports\Drivers\Concerns;

use Symfony\Component\Finder\Finder;

/**
 * Concerns Detection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers\Concerns
 */
trait Detection
{
    /**
     * Detect locales from the names of the directories found in given paths
     *
     * @param string[] $paths
     *
     * @return string[] E.g. en, en-uk, fr, da... etc
     */
    protected function detectLocalesFromDirectories(array $paths): array
    {
        if (empty($paths)) {
            return [];
        }

        $locales = [];

        $found = Finder::create()
            ->in($paths)
            ->directories()
            ->depth(0)
            ->sortByName();

        foreach ($found as $item) {
            $locales[] = $item->getBasename();
        }

        return array_unique($locales);
    }

    /**
     * Detect locales from the json files' names in given paths
     *
     * @param string[] $paths
     *
     * @return string[] E.g. en, en-uk, fr, da... etc
     */
    protected function detectLocalesFromJsonFilesIn(array $paths): array
    {
        if (empty($paths)) {
            return [];
        }

        $locales = [];

        $found = Finder::create()
            ->files()
            ->name('*.json')
            ->ignoreDotFiles(true)
            ->in($paths)
            ->depth(0)
            ->sortByName();

        foreach ($found as $item) {
            $locales[] = $item->getBasename('.' . $item->getExtension());
        }

        return array_unique($locales);
    }

    /**
     * Detect translation groups in given paths
     *
     * @param string[] $paths
     *
     * @return string[]
     */
    protected function detectGroupsIn(array $paths): array
    {
        if (empty($paths)) {
            return [];
        }

        $groups = [];

        // Normal language directory structure looks like this:
        // + en
        //     - messages.php
        // + es
        //     - messages.php
        // ...etc
        // @see https://laravel.com/docs/10.x/localization#introduction

        $found = Finder::create()
            ->files()
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->in($paths)
            ->depth(1)
            ->sortByName();

        foreach ($found as $item) {
            $groups[] = $item->getBasename('.' . $item->getExtension());
        }

        return array_unique($groups);
    }
}
