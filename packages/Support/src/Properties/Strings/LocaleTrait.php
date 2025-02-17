<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Locale Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LocaleAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LocaleTrait
{
    /**
     * Locale language code, e.g. en_us or other format
     *
     * @var string|null
     */
    protected string|null $locale = null;

    /**
     * Set locale
     *
     * @param string|null $code Locale language code, e.g. en_us or other format
     *
     * @return self
     */
    public function setLocale(string|null $code): static
    {
        $this->locale = $code;

        return $this;
    }

    /**
     * Get locale
     *
     * If no locale value set, method
     * sets and returns a default locale.
     *
     * @see getDefaultLocale()
     *
     * @return string|null locale or null if no locale has been set
     */
    public function getLocale(): string|null
    {
        if (!$this->hasLocale()) {
            $this->setLocale($this->getDefaultLocale());
        }
        return $this->locale;
    }

    /**
     * Check if locale has been set
     *
     * @return bool True if locale has been set, false if not
     */
    public function hasLocale(): bool
    {
        return isset($this->locale);
    }

    /**
     * Get a default locale value, if any is available
     *
     * @return string|null Default locale value or null if no default value is available
     */
    public function getDefaultLocale(): string|null
    {
        return null;
    }
}
