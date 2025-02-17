<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Template Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TemplateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TemplateTrait
{
    /**
     * Template or location of a template file
     *
     * @var string|null
     */
    protected string|null $template = null;

    /**
     * Set template
     *
     * @param string|null $template Template or location of a template file
     *
     * @return self
     */
    public function setTemplate(string|null $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * If no template value set, method
     * sets and returns a default template.
     *
     * @see getDefaultTemplate()
     *
     * @return string|null template or null if no template has been set
     */
    public function getTemplate(): string|null
    {
        if (!$this->hasTemplate()) {
            $this->setTemplate($this->getDefaultTemplate());
        }
        return $this->template;
    }

    /**
     * Check if template has been set
     *
     * @return bool True if template has been set, false if not
     */
    public function hasTemplate(): bool
    {
        return isset($this->template);
    }

    /**
     * Get a default template value, if any is available
     *
     * @return string|null Default template value or null if no default value is available
     */
    public function getDefaultTemplate(): string|null
    {
        return null;
    }
}
