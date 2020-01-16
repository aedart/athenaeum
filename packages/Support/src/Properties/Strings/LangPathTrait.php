<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Lang path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LangPathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LangPathTrait
{
    /**
     * Directory path where translation resources are located
     *
     * @var string|null
     */
    protected ?string $langPath = null;

    /**
     * Set lang path
     *
     * @param string|null $path Directory path where translation resources are located
     *
     * @return self
     */
    public function setLangPath(?string $path)
    {
        $this->langPath = $path;

        return $this;
    }

    /**
     * Get lang path
     *
     * If no "lang path" value set, method
     * sets and returns a default "lang path".
     *
     * @see getDefaultLangPath()
     *
     * @return string|null lang path or null if no lang path has been set
     */
    public function getLangPath() : ?string
    {
        if ( ! $this->hasLangPath()) {
            $this->setLangPath($this->getDefaultLangPath());
        }
        return $this->langPath;
    }

    /**
     * Check if "lang path" has been set
     *
     * @return bool True if "lang path" has been set, false if not
     */
    public function hasLangPath() : bool
    {
        return isset($this->langPath);
    }

    /**
     * Get a default "lang path" value, if any is available
     *
     * @return string|null Default "lang path" value or null if no default value is available
     */
    public function getDefaultLangPath() : ?string
    {
        return null;
    }
}
