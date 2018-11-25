<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Content Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ContentAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ContentTrait
{
    /**
     * Content
     *
     * @var string|null
     */
    protected $content = null;

    /**
     * Set content
     *
     * @param string|null $content Content
     *
     * @return self
     */
    public function setContent(?string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * If no "content" value set, method
     * sets and returns a default "content".
     *
     * @see getDefaultContent()
     *
     * @return string|null content or null if no content has been set
     */
    public function getContent() : ?string
    {
        if ( ! $this->hasContent()) {
            $this->setContent($this->getDefaultContent());
        }
        return $this->content;
    }

    /**
     * Check if "content" has been set
     *
     * @return bool True if "content" has been set, false if not
     */
    public function hasContent() : bool
    {
        return isset($this->content);
    }

    /**
     * Get a default "content" value, if any is available
     *
     * @return string|null Default "content" value or null if no default value is available
     */
    public function getDefaultContent() : ?string
    {
        return null;
    }
}
