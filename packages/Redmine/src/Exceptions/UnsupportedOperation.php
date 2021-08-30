<?php

namespace Aedart\Redmine\Exceptions;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;

/**
 * Unsupported Operation Exception
 *
 * @see UnsupportedOperationException
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Exceptions
 */
class UnsupportedOperation extends RedmineException implements UnsupportedOperationException
{
}
