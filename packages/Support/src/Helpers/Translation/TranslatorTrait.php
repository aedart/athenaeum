<?php

namespace Aedart\Support\Helpers\Translation;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Facades\Lang;

/**
 * Translator Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Translation\TranslatorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Translation
 */
trait TranslatorTrait
{
    /**
     * Translator instance
     *
     * @var Translator|null
     */
    protected ?Translator $translator = null;

    /**
     * Set translator
     *
     * @param Translator|null $translator Translator instance
     *
     * @return self
     */
    public function setTranslator(?Translator $translator)
    {
        $this->translator = $translator;

        return $this;
    }

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
    public function getTranslator(): ?Translator
    {
        if (!$this->hasTranslator()) {
            $this->setTranslator($this->getDefaultTranslator());
        }
        return $this->translator;
    }

    /**
     * Check if translator has been set
     *
     * @return bool True if translator has been set, false if not
     */
    public function hasTranslator(): bool
    {
        return isset($this->translator);
    }

    /**
     * Get a default translator value, if any is available
     *
     * @return Translator|null A default translator value or Null if no default value is available
     */
    public function getDefaultTranslator(): ?Translator
    {
        return Lang::getFacadeRoot();
    }
}
