<?php

namespace Aedart\Contracts\Utils\Packages\Exceptions;

/**
 * Package Not Installed Exception
 *
 * Should be thrown whenever a version is requested for a package that
 * is not installed.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Packages\Exceptions
 */
interface PackageNotInstalledException extends PackageVersionException
{
}
