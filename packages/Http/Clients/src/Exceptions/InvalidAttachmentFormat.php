<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException;
use InvalidArgumentException;

/**
 * Invalid Attachment Format Exception
 *
 * @see \Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class InvalidAttachmentFormat extends InvalidArgumentException implements InvalidAttachmentFormatException
{
}
