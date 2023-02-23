<?php

namespace Aedart\Translation\Traits;

use Aedart\Contracts\Translation\Exports\Manager;
use Aedart\Support\Facades\IoCFacade;

/**
 * Translations Exporter Manager Trait
 *
 * @see \Aedart\Contracts\Translation\Exports\TranslationsExporterManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Traits
 */
trait TranslationsExporterManagerTrait
{
    /**
     * Translations Export Manager instance
     *
     * @var Manager|null
     */
    protected Manager|null $translationsExporterManager = null;

    /**
     * Set translations exporter manager
     *
     * @param Manager|null $manager Translations Export Manager instance
     *
     * @return self
     */
    public function setTranslationsExporterManager(Manager|null $manager): static
    {
        $this->translationsExporterManager = $manager;

        return $this;
    }

    /**
     * Get translations exporter manager
     *
     * If no translations exporter manager has been set, this method will
     * set and return a default translations exporter manager, if any such
     * value is available
     *
     * @return Manager|null translations exporter manager or null if none translations exporter manager has been set
     */
    public function getTranslationsExporterManager(): Manager|null
    {
        if (!$this->hasTranslationsExporterManager()) {
            $this->setTranslationsExporterManager($this->getDefaultTranslationsExporterManager());
        }
        return $this->translationsExporterManager;
    }

    /**
     * Check if translations exporter manager has been set
     *
     * @return bool True if translations exporter manager has been set, false if not
     */
    public function hasTranslationsExporterManager(): bool
    {
        return isset($this->translationsExporterManager);
    }

    /**
     * Get a default translations exporter manager value, if any is available
     *
     * @return Manager|null A default translations exporter manager value or Null if no default value is available
     */
    public function getDefaultTranslationsExporterManager(): Manager|null
    {
        return IoCFacade::tryMake(Manager::class);
    }
}
