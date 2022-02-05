<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars\Dates;

use DateTimeInterface;

/**
 * Date Value
 *
 * Wrapper for date-based values in where expressions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars\Dates
 */
class DateValue
{
    /**
     * The date that was given
     *
     * @var string|DateTimeInterface|null
     */
    protected string|DateTimeInterface|null $date;

    /**
     * The date format
     *
     * @var string
     */
    protected string $format;

    /**
     * DateValue constructor.
     *
     * @param string|DateTimeInterface|null $date
     * @param string $format
     */
    public function __construct(string|DateTimeInterface|null $date, string $format)
    {
        $this->date = $date;
        $this->format = $format;
    }

    /**
     * Get the date that was set as value
     *
     * @return DateTimeInterface|string|null
     */
    public function date(): string|DateTimeInterface|null
    {
        return $this->date;
    }

    /**
     * Get the date format
     *
     * @return string
     */
    public function format(): string
    {
        return $this->format;
    }
}
