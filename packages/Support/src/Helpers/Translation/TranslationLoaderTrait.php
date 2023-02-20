<?php

namespace Aedart\Support\Helpers\Translation;

use Aedart\Support\Facades\IoCFacade;
use Illuminate\Contracts\Translation\Loader;

/**
 * Translation Loader Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Translation\TranslationLoaderAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Translation
 */
trait TranslationLoaderTrait
{
    /**
     * Translation Loader instance
     *
     * @var Loader|null
     */
    protected Loader|null $translationLoader = null;

    /**
     * Set translation loader
     *
     * @param Loader|null $loader Translation Loader instance
     *
     * @return self
     */
    public function setTranslationLoader(Loader|null $loader): static
    {
        $this->translationLoader = $loader;

        return $this;
    }

    /**
     * Get translation loader
     *
     * If no translation loader has been set, this method will
     * set and return a default translation loader, if any such
     * value is available
     *
     * @return Loader|null translation loader or null if none translation loader has been set
     */
    public function getTranslationLoader(): Loader|null
    {
        if (!$this->hasTranslationLoader()) {
            $this->setTranslationLoader($this->getDefaultTranslationLoader());
        }
        return $this->translationLoader;
    }

    /**
     * Check if translation loader has been set
     *
     * @return bool True if translation loader has been set, false if not
     */
    public function hasTranslationLoader(): bool
    {
        return isset($this->translationLoader);
    }

    /**
     * Get a default translation loader value, if any is available
     *
     * @return Loader|null A default translation loader value or Null if no default value is available
     */
    public function getDefaultTranslationLoader(): Loader|null
    {
        return IoCFacade::tryMake('translation.loader');
    }
}