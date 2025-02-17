<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Html Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\HtmlAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait HtmlTrait
{
    /**
     * HyperText Markup Language (HTML)
     *
     * @var mixed
     */
    protected $html = null;

    /**
     * Set html
     *
     * @param mixed $html HyperText Markup Language (HTML)
     *
     * @return self
     */
    public function setHtml(mixed $html): static
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * If no html value set, method
     * sets and returns a default html.
     *
     * @see getDefaultHtml()
     *
     * @return mixed html or null if no html has been set
     */
    public function getHtml(): mixed
    {
        if (!$this->hasHtml()) {
            $this->setHtml($this->getDefaultHtml());
        }
        return $this->html;
    }

    /**
     * Check if html has been set
     *
     * @return bool True if html has been set, false if not
     */
    public function hasHtml(): bool
    {
        return isset($this->html);
    }

    /**
     * Get a default html value, if any is available
     *
     * @return mixed Default html value or null if no default value is available
     */
    public function getDefaultHtml(): mixed
    {
        return null;
    }
}
