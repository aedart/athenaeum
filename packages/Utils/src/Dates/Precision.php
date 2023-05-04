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
    case Year;
    case Month;
    case Day;
    case Hour;
    case Minute;
    case Second;
    case Millisecond;
}
