<?php

namespace Aedart\Translation\Exports\Exceptions;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException as ExporterExceptionInterface;
use RuntimeException;

/**
 * Exporter Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Exceptions
 */
class ExporterException extends RuntimeException implements ExporterExceptionInterface
{
}
