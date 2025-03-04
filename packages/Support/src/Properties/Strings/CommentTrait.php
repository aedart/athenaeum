<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Comment Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CommentAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CommentTrait
{
    /**
     * A comment
     *
     * @var string|null
     */
    protected string|null $comment = null;

    /**
     * Set comment
     *
     * @param string|null $content A comment
     *
     * @return self
     */
    public function setComment(string|null $content): static
    {
        $this->comment = $content;

        return $this;
    }

    /**
     * Get comment
     *
     * If no comment value set, method
     * sets and returns a default comment.
     *
     * @see getDefaultComment()
     *
     * @return string|null comment or null if no comment has been set
     */
    public function getComment(): string|null
    {
        if (!$this->hasComment()) {
            $this->setComment($this->getDefaultComment());
        }
        return $this->comment;
    }

    /**
     * Check if comment has been set
     *
     * @return bool True if comment has been set, false if not
     */
    public function hasComment(): bool
    {
        return isset($this->comment);
    }

    /**
     * Get a default comment value, if any is available
     *
     * @return string|null Default comment value or null if no default value is available
     */
    public function getDefaultComment(): string|null
    {
        return null;
    }
}
