<?php

namespace Aedart\Circuits\Exceptions;

use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;
use RuntimeException;

/**
 * Profile Not Found Exception
 *
 * @see \Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Exceptions
 */
class ProfileNotFound extends RuntimeException implements ProfileNotFoundException
{
}
