<?php

namespace Aedart\Contracts\Translation\Exports;

/**
 * Translations Exporter Manager Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Translation\Exports
 */
interface TranslationsExporterManagerAware
{
    /**
     * Set translations exporter manager
     *
     * @param Manager|null $manager Translations Export Manager instance
     *
     * @return static
     */
    public function setTranslationsExporterManager(Manager|null $manager): static;

    /**
     * Get translations exporter manager
     *
     * If no translations exporter manager has been set, this method will
     * set and return a default translations exporter manager, if any such
     * value is available
     *
     * @return Manager|null translations exporter manager or null if none translations exporter manager has been set
     */
    public function getTranslationsExporterManager(): Manager|null;

    /**
     * Check if translations exporter manager has been set
     *
     * @return bool True if translations exporter manager has been set, false if not
     */
    public function hasTranslationsExporterManager(): bool;

    /**
     * Get a default translations exporter manager value, if any is available
     *
     * @return Manager|null A default translations exporter manager value or Null if no default value is available
     */
    public function getDefaultTranslationsExporterManager(): Manager|null;
}
