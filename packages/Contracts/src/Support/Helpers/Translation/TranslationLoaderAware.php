<?php

namespace Aedart\Contracts\Support\Helpers\Translation;

use Illuminate\Contracts\Translation\Loader;

/**
 * Translation Loader Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Translation
 */
interface TranslationLoaderAware
{
    /**
     * Set translation loader
     *
     * @param Loader|null $loader Translation Loader instance
     *
     * @return self
     */
    public function setTranslationLoader(Loader|null $loader): static;

    /**
     * Get translation loader
     *
     * If no translation loader has been set, this method will
     * set and return a default translation loader, if any such
     * value is available
     *
     * @return Loader|null translation loader or null if none translation loader has been set
     */
    public function getTranslationLoader(): Loader|null;

    /**
     * Check if translation loader has been set
     *
     * @return bool True if translation loader has been set, false if not
     */
    public function hasTranslationLoader(): bool;

    /**
     * Get a default translation loader value, if any is available
     *
     * @return Loader|null A default translation loader value or Null if no default value is available
     */
    public function getDefaultTranslationLoader(): Loader|null;
}
