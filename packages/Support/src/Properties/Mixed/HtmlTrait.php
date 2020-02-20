<?php

namespace Aedart\Support\Properties\Mixed;

/**
 * @deprecated Since v4.0, please use \Aedart\Support\Properties\Mixes\HtmlTrait instead
 *
 * Html Trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixed
 */
trait HtmlTrait
{
    /**
     * HyperText Markup Language (HTML)
     *
     * @var mixed|null
     */
    protected $html = null;

    /**
     * Set html
     *
     * @param mixed|null $html HyperText Markup Language (HTML)
     *
     * @return self
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * If no "html" value set, method
     * sets and returns a default "html".
     *
     * @see getDefaultHtml()
     *
     * @return mixed|null html or null if no html has been set
     */
    public function getHtml()
    {
        if (!$this->hasHtml()) {
            $this->setHtml($this->getDefaultHtml());
        }
        return $this->html;
    }

    /**
     * Check if "html" has been set
     *
     * @return bool True if "html" has been set, false if not
     */
    public function hasHtml(): bool
    {
        return isset($this->html);
    }

    /**
     * Get a default "html" value, if any is available
     *
     * @return mixed|null Default "html" value or null if no default value is available
     */
    public function getDefaultHtml()
    {
        return null;
    }
}
