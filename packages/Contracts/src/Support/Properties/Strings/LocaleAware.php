<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Locale Aware
 *
 * Component is aware of string "locale"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LocaleAware
{
    /**
     * Set locale
     *
     * @param string|null $code Locale language code, e.g. en_us or other format
     *
     * @return self
     */
    public function setLocale(string|null $code): static;

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
    public function getLocale(): string|null;

    /**
     * Check if locale has been set
     *
     * @return bool True if locale has been set, false if not
     */
    public function hasLocale(): bool;

    /**
     * Get a default locale value, if any is available
     *
     * @return string|null Default locale value or null if no default value is available
     */
    public function getDefaultLocale(): string|null;
}
