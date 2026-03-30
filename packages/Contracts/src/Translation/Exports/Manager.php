<?php

namespace Aedart\Contracts\Translation\Exports;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;

/**
 * Translations Exporter Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Translation\Exports
 */
interface Manager
{
    /**
     * Creates a new exporter instance or returns existing
     *
     * @param string|null $name [optional] Name of exporter profile to obtain or create
     * @param array $options [optional] Exporter options
     *
     * @return Exporter
     *
     * @throws ProfileNotFoundException
     */
    public function profile(string|null $name = null, array $options = []): Exporter;

    /**
     * Creates a new exporter instance
     *
     * @param class-string<Exporter>|null $driver [optional] Class path to {@see Exporter} to use
     * @param array $options [optional] Exporter specific options
     *
     * @return Exporter
     */
    public function exporter(string|null $driver, array $options = []): Exporter;

    /**
     * Returns class path of a default exporter to use
     *
     * @return class-string<Exporter>
     */
    public function defaultExporter(): string;
}
