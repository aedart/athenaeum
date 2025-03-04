<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Xml Aware
 *
 * Component is aware of mixed "xml"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixes
 */
interface XmlAware
{
    /**
     * Set xml
     *
     * @param mixed $xml Extensible Markup Language (XML)
     *
     * @return self
     */
    public function setXml(mixed $xml): static;

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
    public function getXml(): mixed;

    /**
     * Check if xml has been set
     *
     * @return bool True if xml has been set, false if not
     */
    public function hasXml(): bool;

    /**
     * Get a default xml value, if any is available
     *
     * @return mixed Default xml value or null if no default value is available
     */
    public function getDefaultXml(): mixed;
}
