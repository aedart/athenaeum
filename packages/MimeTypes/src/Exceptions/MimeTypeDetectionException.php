<?php

namespace Aedart\MimeTypes\Exceptions;

use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException as MimeTypeDetectionExceptionInterface;
use RuntimeException;

/**
 * Mime Type Detection Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes\Exceptions
 */
class MimeTypeDetectionException extends RuntimeException implements MimeTypeDetectionExceptionInterface
{
}
