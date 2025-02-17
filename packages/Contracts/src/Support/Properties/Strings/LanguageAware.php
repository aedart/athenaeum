<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Language Aware
 *
 * Component is aware of string "language"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LanguageAware
{
    /**
     * Set language
     *
     * @param string|null $identifier Name or identifier of a language
     *
     * @return self
     */
    public function setLanguage(string|null $identifier): static;

    /**
     * Get language
     *
     * If no language value set, method
     * sets and returns a default language.
     *
     * @see getDefaultLanguage()
     *
     * @return string|null language or null if no language has been set
     */
    public function getLanguage(): string|null;

    /**
     * Check if language has been set
     *
     * @return bool True if language has been set, false if not
     */
    public function hasLanguage(): bool;

    /**
     * Get a default language value, if any is available
     *
     * @return string|null Default language value or null if no default value is available
     */
    public function getDefaultLanguage(): string|null;
}
