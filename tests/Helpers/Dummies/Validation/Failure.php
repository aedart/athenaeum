<?php

namespace Aedart\Tests\Helpers\Dummies\Validation;

use Aedart\Contracts\Validation\FailedState;

/**
 * Failure
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Validation
 */
enum Failure implements FailedState
{
    /**
     * No input was given...
     */
    case NOT_INPUT;

    /**
     * Input does not meet minimum length requirement
     */
    case MIN_LENGTH;

    /**
     * Input exceeds maximum length requirement
     */
    case MAX_LENGTH;
}
