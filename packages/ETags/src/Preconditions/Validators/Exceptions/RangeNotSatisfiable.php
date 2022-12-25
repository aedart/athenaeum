<?php

namespace Aedart\ETags\Preconditions\Validators\Exceptions;

use Aedart\Contracts\ETags\Preconditions\Exceptions\RangeNotSatisfiableException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Range Not Satisfiable Exception
 *
 * @see \Aedart\Contracts\ETags\Preconditions\Exceptions\RangeNotSatisfiableException
 * @see \Symfony\Component\HttpKernel\Exception\HttpException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Validators\Exceptions
 */
class RangeNotSatisfiable extends HttpException implements RangeNotSatisfiableException
{
    /**
     * Range that cannot be satisfied
     *
     * @var string
     */
    protected string $range;

    /**
     * Total size of requested resource
     *
     * @var int
     */
    protected int $totalSize;

    /**
     * Supported range unit
     *
     * @var string
     */
    protected string $rangeUnit;

    /**
     * Creates a new "416 Range Not Satisfiable" Http Exception
     *
     * @param  string  $range Range that cannot be satisfied
     * @param  int  $totalSize Total size of requested resource
     * @param  string  $rangeUnit Supported range unit, e.g. bytes
     * @param  string  $message  [optional]
     * @param  Throwable|null  $previous  [optional]
     * @param  array  $headers  [optional]
     * @param  int  $code  [optional]
     */
    public function __construct(
        string $range,
        int $totalSize,
        string $rangeUnit,
        string $message = '',
        Throwable $previous = null,
        array $headers = [],
        int $code = 0
    ) {
        $this->range = $range;
        $this->totalSize = $totalSize;
        $this->rangeUnit = $rangeUnit;

        // Resolve message when given
        if (empty($message) && isset($previous)) {
            $message = $previous->getMessage();
        }
        if (empty($message)) {
            $message = sprintf('Range: %s cannot be satisfied', $range);
        }

        // [...] A server generating a 416 (Range Not Satisfiable) response to a byte-range request
        // SHOULD send a Content-Range header field with an unsatisfied-range value, [...]
        if ($rangeUnit === 'bytes' && !isset($headers['Content-Range'])) {
            $headers['Content-Range'] = "{$rangeUnit} */{$totalSize}";
        }

        parent::__construct(416, $message, $previous, $headers, $code);
    }


    /**
     * @inheritDoc
     */
    public function getRange(): string
    {
        return $this->range;
    }

    /**
     * @inheritDoc
     */
    public function getTotalSize(): int
    {
        return $this->totalSize;
    }

    /**
     * @inheritDoc
     */
    public function getRangeUnit(): string
    {
        return $this->rangeUnit;
    }
}