<?php

namespace Aedart\Utils;

use Aedart\Contracts\Utils\Packages\Exceptions\PackageNotInstalledException;
use Aedart\Contracts\Utils\Packages\Exceptions\PackageVersionException;
use Aedart\Contracts\Utils\Packages\Version as PackageVersionInterface;
use Aedart\Utils\Packages\Exceptions\NotInstalled;
use Aedart\Utils\Packages\Exceptions\UnableToResolveVersion;
use Aedart\Utils\Packages\PackageVersion;
use Composer\InstalledVersions;

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
     * @var array Key-value pair, key = package name, value = PackageVersionInterface
     */
    protected static array $versions = [];

    /**
     * Returns the application's version
     *
     * @return PackageVersionInterface
     */
    public static function application(): PackageVersionInterface
    {
        $root = InstalledVersions::getRootPackage();
        $name = $root['name'];

        if (isset(static::$versions[$name])) {
            return static::$versions[$name];
        }

        return static::$versions[$name] = static::makePackageVersion(
            name: $name,
            version: $root['pretty_version'],
            fullVersion: $root['version'],
            reference: $root['reference']
        );
    }

    /**
     * Returns the version of the given package
     *
     * @param string $name Name of package
     *
     * @return PackageVersionInterface
     *
     * @throws PackageVersionException
     */
    public static function package(string $name): PackageVersionInterface
    {
        if (isset(static::$versions[$name])) {
            return static::$versions[$name];
        }

        if (!static::hasFor($name)) {
            throw new NotInstalled(sprintf('package %s does not appear to be installed', $name));
        }

        // Obtain raw information about installed packages from composer
        $raw = InstalledVersions::getAllRawData();
        $package = [];
        foreach ($raw as $installed) {
            if (isset($installed['versions'][$name])) {
                $package = $installed['versions'][$name];
                break;
            }
        }

        // Abort if for some reason package information is not available
        if (empty($package)) {
            throw new UnableToResolveVersion(sprintf('no meta information is available for package %s. Unable to determine version!', $name));
        }

        // Package is replaced, so we are only able to show the first version
        // that is listed in the "replaced" entry.
        if (isset($package['replaced'])) {
            return static::$versions[$name] = static::makePackageVersion(
                name: $name,
                version: $package['replaced'][0]
            );
        }

        // Finally, return the package version information
        return static::$versions[$name] = static::makePackageVersion(
            name: $name,
            version: $package['pretty_version'],
            fullVersion: $package['version'],
            reference: $package['reference']
        );
    }

    /**
     * Determine if a version is available for given package
     *
     * @param  string  $package
     * @param  bool  $includeDevRequirements  [optional]
     *
     * @return bool
     */
    public static function hasFor(string $package, bool $includeDevRequirements = true): bool
    {
        if (isset(static::$versions[$package])) {
            return true;
        }

        return InstalledVersions::isInstalled($package, $includeDevRequirements);
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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a new package version dto
     *
     * @param ...$args
     *
     * @return PackageVersionInterface
     */
    protected static function makePackageVersion(...$args): PackageVersionInterface
    {
        return new PackageVersion(...$args);
    }
}
