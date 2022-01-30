<?php

namespace Aedart\Utils\Packages\Exceptions;

use Aedart\Contracts\Utils\Packages\Exceptions\PackageNotInstalledException;
use RuntimeException;

/**
 * Package Not Installed Exception
 *
 * @see \Aedart\Contracts\Utils\Packages\Exceptions\PackageNotInstalledException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Packages\Exceptions
 */
class NotInstalled extends RuntimeException implements PackageNotInstalledException
{
}
