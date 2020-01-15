<?php

namespace Aedart\Contracts\Support\Helpers\Translation;

use Illuminate\Contracts\Translation\Translator;

/**
 * Translator Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Translation
 */
interface TranslatorAware
{
    /**
     * Set translator
     *
     * @param Translator|null $translator Translator instance
     *
     * @return self
     */
    public function setTranslator(?Translator $translator);

    /**
     * Get translator
     *
     * If no translator has been set, this method will
     * set and return a default translator, if any such
     * value is available
     *
     * @see getDefaultTranslator()
     *
     * @return Translator|null translator or null if none translator has been set
     */
    public function getTranslator(): ?Translator;

    /**
     * Check if translator has been set
     *
     * @return bool True if translator has been set, false if not
     */
    public function hasTranslator(): bool;

    /**
     * Get a default translator value, if any is available
     *
     * @return Translator|null A default translator value or Null if no default value is available
     */
    public function getDefaultTranslator(): ?Translator;
}
