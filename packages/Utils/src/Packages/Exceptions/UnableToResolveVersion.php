<?php

namespace Aedart\Utils\Packages\Exceptions;

use Aedart\Contracts\Utils\Packages\Exceptions\PackageVersionException;
use RuntimeException;

/**
 * Unable To Resolve Version Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Packages\Exceptions
 */
class UnableToResolveVersion extends RuntimeException implements PackageVersionException
{
}
