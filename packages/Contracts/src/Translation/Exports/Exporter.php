<?php

namespace Aedart\Contracts\Translation\Exports;

/**
 * Translations Exporter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Translation\Exports
 */
interface Exporter
{
    /**
     * Detects the available locales
     *
     * @return string[]
     */
    public function detectLocals(): array;

    /**
     * Add one or more paths to be searched
     *
     * @param string|string[] $paths
     *
     * @return self
     */
    public function addPaths(string|array $paths): static;

    /**
     * Set the paths to be searched
     *
     * @param string[] $paths
     *
     * @return self
     */
    public function setPaths(array $paths): static;

    /**
     * Get paths to be searched
     *
     * @return string[]
     */
    public function getPaths(): array;
}