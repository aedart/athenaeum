<?php

namespace Aedart\Antivirus\Exceptions;

use Aedart\Contracts\Antivirus\Exceptions\UnsupportedStatusValueException;

/**
 * Unsupported Status Value
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Exceptions
 */
class UnsupportedStatusValue extends AntivirusException implements UnsupportedStatusValueException
{
}
