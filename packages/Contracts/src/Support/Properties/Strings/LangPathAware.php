<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Lang path Aware
 *
 * Component is aware of string "lang path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LangPathAware
{
    /**
     * Set lang path
     *
     * @param string|null $path Directory path where translation resources are located
     *
     * @return self
     */
    public function setLangPath(string|null $path): static;

    /**
     * Get lang path
     *
     * If no lang path value set, method
     * sets and returns a default lang path.
     *
     * @see getDefaultLangPath()
     *
     * @return string|null lang path or null if no lang path has been set
     */
    public function getLangPath(): string|null;

    /**
     * Check if lang path has been set
     *
     * @return bool True if lang path has been set, false if not
     */
    public function hasLangPath(): bool;

    /**
     * Get a default lang path value, if any is available
     *
     * @return string|null Default lang path value or null if no default value is available
     */
    public function getDefaultLangPath(): string|null;
}
