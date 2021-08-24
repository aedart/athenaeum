<?php

namespace Aedart\Redmine\Exceptions;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;

/**
 * Invalid Connection
 *
 * @see ConnectionException
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Exceptions
 */
class InvalidConnection extends RedmineException implements ConnectionException
{
}
