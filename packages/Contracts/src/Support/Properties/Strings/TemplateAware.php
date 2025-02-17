<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Template Aware
 *
 * Component is aware of string "template"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TemplateAware
{
    /**
     * Set template
     *
     * @param string|null $template Template or location of a template file
     *
     * @return self
     */
    public function setTemplate(string|null $template): static;

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
    public function getTemplate(): string|null;

    /**
     * Check if template has been set
     *
     * @return bool True if template has been set, false if not
     */
    public function hasTemplate(): bool;

    /**
     * Get a default template value, if any is available
     *
     * @return string|null Default template value or null if no default value is available
     */
    public function getDefaultTemplate(): string|null;
}
