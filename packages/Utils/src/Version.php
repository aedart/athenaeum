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
     * Cache of packages and version
     *
     * @var array Key-value pair, key = package name, value = \Jean85\Version instance
     */
    protected static array $versions = [];

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
        if (isset(static::$versions[$name])) {
            return static::$versions[$name];
        }

        return static::$versions[$name] = PrettyVersions::getVersion($name);
    }

    /**
     * Determine if a version is available for given package
     *
     * @param string $package Name of package
     *
     * @return bool
     */
    public static function hasFor(string $package): bool
    {
        if (isset(static::$versions[$package])) {
            return true;
        }

        try {
            $version = static::package($package);
            if (isset($version)) {
                return true;
            }
        } catch (OutOfBoundsException $e) {
            // This means that the package was not installed / found.
            // This we can safely ignore.
        }

        return false;
    }

    /**
     * Returns the cached package's version
     *
     * @return array Key-value pair, key = package name, value = \Jean85\Version instance
     */
    public static function cached(): array
    {
        return static::$versions;
    }

    /**
     * Clear the cached package's version
     *
     * @return bool
     */
    public static function clearCached(): bool
    {
        static::$versions = [];

        return true;
    }
}
