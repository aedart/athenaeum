<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Xml Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\XmlAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait XmlTrait
{
    /**
     * Extensible Markup Language (XML)
     *
     * @var mixed
     */
    protected $xml = null;

    /**
     * Set xml
     *
     * @param mixed $xml Extensible Markup Language (XML)
     *
     * @return self
     */
    public function setXml(mixed $xml): static
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
     * @return mixed xml or null if no xml has been set
     */
    public function getXml(): mixed
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
     * @return mixed Default xml value or null if no default value is available
     */
    public function getDefaultXml(): mixed
    {
        return null;
    }
}
