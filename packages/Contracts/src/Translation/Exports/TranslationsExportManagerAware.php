<?php

namespace Aedart\Contracts\Translation\Exports;

/**
 * Translations Export Manager Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Translation\Exports
 */
interface TranslationsExportManagerAware
{
    /**
     * Set translations export manager
     *
     * @param Manager|null $manager Translations Export Manager instance
     *
     * @return static
     */
    public function setTranslationsExportManager(Manager|null $manager): static;

    /**
     * Get translations export manager
     *
     * If no translations export manager has been set, this method will
     * set and return a default translations export manager, if any such
     * value is available
     *
     * @return Manager|null translations export manager or null if none translations export manager has been set
     */
    public function getTranslationsExportManager(): Manager|null;

    /**
     * Check if translations export manager has been set
     *
     * @return bool True if translations export manager has been set, false if not
     */
    public function hasTranslationsExportManager(): bool;

    /**
     * Get a default translations export manager value, if any is available
     *
     * @return Manager|null A default translations export manager value or Null if no default value is available
     */
    public function getDefaultTranslationsExportManager(): Manager|null;
}