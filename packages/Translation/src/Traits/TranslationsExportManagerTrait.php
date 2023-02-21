<?php

namespace Aedart\Translation\Traits;

use Aedart\Contracts\Translation\Exports\Manager;
use Aedart\Support\Facades\IoCFacade;

/**
 * Translations Export Manager Trait
 *
 * @see \Aedart\Contracts\Translation\Exports\TranslationsExportManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Traits
 */
trait TranslationsExportManagerTrait
{
    /**
     * Translations Export Manager instance
     *
     * @var Manager|null
     */
    protected Manager|null $translationsExportManager = null;

    /**
     * Set translations export manager
     *
     * @param Manager|null $manager Translations Export Manager instance
     *
     * @return self
     */
    public function setTranslationsExportManager(Manager|null $manager): static
    {
        $this->translationsExportManager = $manager;

        return $this;
    }

    /**
     * Get translations export manager
     *
     * If no translations export manager has been set, this method will
     * set and return a default translations export manager, if any such
     * value is available
     *
     * @return Manager|null translations export manager or null if none translations export manager has been set
     */
    public function getTranslationsExportManager(): Manager|null
    {
        if (!$this->hasTranslationsExportManager()) {
            $this->setTranslationsExportManager($this->getDefaultTranslationsExportManager());
        }
        return $this->translationsExportManager;
    }

    /**
     * Check if translations export manager has been set
     *
     * @return bool True if translations export manager has been set, false if not
     */
    public function hasTranslationsExportManager(): bool
    {
        return isset($this->translationsExportManager);
    }

    /**
     * Get a default translations export manager value, if any is available
     *
     * @return Manager|null A default translations export manager value or Null if no default value is available
     */
    public function getDefaultTranslationsExportManager(): Manager|null
    {
        return IoCFacade::tryMake(Manager::class);
    }
}