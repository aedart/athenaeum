<?php

namespace Aedart\Antivirus\Exceptions;

use Aedart\Contracts\Antivirus\Exceptions\AntivirusException as AntivirusExceptionInterface;
use RuntimeException;

/**
 * Antivirus Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Exceptions
 */
class AntivirusException extends RuntimeException implements AntivirusExceptionInterface
{
}
