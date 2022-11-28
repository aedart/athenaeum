<?php

namespace Aedart\ETags\Exceptions;

use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use RuntimeException;

/**
 * Profile Not Found Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Exceptions
 */
class ProfileNotFound extends RuntimeException implements ProfileNotFoundException
{
}