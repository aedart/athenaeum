<?php

namespace Aedart\Antivirus\Exceptions;

use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use RuntimeException;

/**
 * Profile Not Found
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Exceptions
 */
class ProfileNotFound extends RuntimeException implements ProfileNotFoundException
{
}
