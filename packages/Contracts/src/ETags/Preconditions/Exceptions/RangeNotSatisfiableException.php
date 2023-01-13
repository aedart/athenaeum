<?php

namespace Aedart\Contracts\ETags\Preconditions\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Range Not Satisfiable Exception
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/416
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions\Exceptions
 */
interface RangeNotSatisfiableException extends InvalidRangeException, HttpExceptionInterface
{
    /**
     * Returns the range that could not be satisfied
     *
     * @return string
     */
    public function getRange(): string;

    /**
     * Returns requested resource's total size
     *
     * @return int
     */
    public function getTotalSize(): int;

    /**
     * Returns the supported range unit
     *
     * @return string E.g. bytes
     */
    public function getRangeUnit(): string;
}