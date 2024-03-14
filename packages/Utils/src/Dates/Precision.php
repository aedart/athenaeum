<?php

namespace Aedart\Utils\Dates;

/**
 * Precision
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Dates
 */
enum Precision
{
    /**
     * Yearly time precision
     */
    case Year;

    /**
     * Monthly time precision
     */
    case Month;

    /**
     * Daily time precision
     */
    case Day;

    /**
     * Hourly time precision
     */
    case Hour;

    /**
     * Minutes time precision
     */
    case Minute;

    /**
     * Seconds time precision
     */
    case Second;

    /**
     * Milliseconds time precision
     */
    case Millisecond;
}
