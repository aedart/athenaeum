<?php

namespace Aedart\Translation\Exports\Exceptions;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use RuntimeException;

/**
 * Profile Not Found Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Exceptions
 */
class ProfileNotFound extends RuntimeException implements ProfileNotFoundException
{
}
