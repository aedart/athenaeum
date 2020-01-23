<?php

namespace Aedart\Utils;

use Jean85\PrettyVersions;
use OutOfBoundsException;

/**
 * Version Utility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Version
{
    /**
     * Returns the version of the given package
     *
     * @see \Jean85\PrettyVersions::getVersion
     *
     * @param string $name Name of package
     *
     * @return \Jean85\Version
     *
     * @throws OutOfBoundsException If a version cannot be located
     */
    public static function package(string $name)
    {
        return PrettyVersions::getVersion($name);
    }
}
