<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;

/**
 * Profile Not Found
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class ProfileNotFound extends \RuntimeException implements ProfileNotFoundException
{
}
