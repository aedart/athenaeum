<?php

namespace Aedart\Contracts\Support\Properties\Mixed;

/**
 * Xml Aware
 *
 * Component is aware of mixed "xml"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixed
 */
interface XmlAware
{
    /**
     * Set xml
     *
     * @param mixed|null $xml Extensible Markup Language (XML)
     *
     * @return self
     */
    public function setXml($xml);

    /**
     * Get xml
     *
     * If no "xml" value set, method
     * sets and returns a default "xml".
     *
     * @see getDefaultXml()
     *
     * @return mixed|null xml or null if no xml has been set
     */
    public function getXml();

    /**
     * Check if "xml" has been set
     *
     * @return bool True if "xml" has been set, false if not
     */
    public function hasXml(): bool;

    /**
     * Get a default "xml" value, if any is available
     *
     * @return mixed|null Default "xml" value or null if no default value is available
     */
    public function getDefaultXml();
}
