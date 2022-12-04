<?php

namespace Aedart\ETags\Exceptions;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use RuntimeException;

/**
 * Invalid Etag Collection Entry
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Exceptions
 */
class InvalidETagCollectionEntry extends RuntimeException implements ETagException
{
}
