<?php

namespace Aedart\Redmine\Exceptions;

use Aedart\Contracts\Redmine\Exceptions\RedmineException as RedmineExceptionInterface;
use RuntimeException;

/**
 * Redmine Exception
 *
 * @see RedmineExceptionInterface
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Exceptions
 */
class RedmineException extends RuntimeException implements RedmineExceptionInterface
{
}
