<?php

namespace Aedart\Contracts\Http\Messages\Exceptions;

use Throwable;

/**
 * Serialization Exception
 *
 * Should be thrown if unable to serialise a Http Message.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages\Exceptions
 */
interface SerializationException extends Throwable
{

}
