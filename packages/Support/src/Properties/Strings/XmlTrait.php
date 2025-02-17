<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Xml Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\XmlAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait XmlTrait
{
    /**
     * Extensible Markup Language (XML)
     *
     * @var string|null
     */
    protected string|null $xml = null;

    /**
     * Set xml
     *
     * @param string|null $xml Extensible Markup Language (XML)
     *
     * @return self
     */
    public function setXml(string|null $xml): static
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * Get xml
     *
     * If no xml value set, method
     * sets and returns a default xml.
     *
     * @see getDefaultXml()
     *
     * @return string|null xml or null if no xml has been set
     */
    public function getXml(): string|null
    {
        if (!$this->hasXml()) {
            $this->setXml($this->getDefaultXml());
        }
        return $this->xml;
    }

    /**
     * Check if xml has been set
     *
     * @return bool True if xml has been set, false if not
     */
    public function hasXml(): bool
    {
        return isset($this->xml);
    }

    /**
     * Get a default xml value, if any is available
     *
     * @return string|null Default xml value or null if no default value is available
     */
    public function getDefaultXml(): string|null
    {
        return null;
    }
}
