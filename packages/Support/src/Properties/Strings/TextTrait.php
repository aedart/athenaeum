<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Text Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TextAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TextTrait
{
    /**
     * The full text content for something, e.g. an article&amp;#039;s body text
     *
     * @var string|null
     */
    protected string|null $text = null;

    /**
     * Set text
     *
     * @param string|null $text The full text content for something, e.g. an article&amp;#039;s body text
     *
     * @return self
     */
    public function setText(string|null $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * If no text value set, method
     * sets and returns a default text.
     *
     * @see getDefaultText()
     *
     * @return string|null text or null if no text has been set
     */
    public function getText(): string|null
    {
        if (!$this->hasText()) {
            $this->setText($this->getDefaultText());
        }
        return $this->text;
    }

    /**
     * Check if text has been set
     *
     * @return bool True if text has been set, false if not
     */
    public function hasText(): bool
    {
        return isset($this->text);
    }

    /**
     * Get a default text value, if any is available
     *
     * @return string|null Default text value or null if no default value is available
     */
    public function getDefaultText(): string|null
    {
        return null;
    }
}
