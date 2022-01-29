<?php

namespace Aedart\Circuits\Exceptions;

use Aedart\Contracts\Circuits\Exceptions\ServiceUnavailableException;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;

/**
 * Service Unavailable Exception
 *
 * @see \Aedart\Contracts\Circuits\Exceptions\ServiceUnavailableException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Exceptions
 */
class ServiceUnavailable extends CircuitBreakerException implements ServiceUnavailableException
{
    /**
     * Creates a new instance with a predefined message,
     * based on given arguments
     *
     * @param string $service
     * @param State $lastState
     * @param Failure|null $lastFailure [optional]
     *
     * @return ServiceUnavailableException
     */
    public static function make(string $service, State $lastState, Failure|null $lastFailure = null): ServiceUnavailableException
    {
        $reason = isset($lastFailure)
            ? $lastFailure->reason()
            : 'unknown';

        $message = sprintf(
            '%s is unavailable. Circuit Breaker\'s state was %s. Last detected failure was: %s',
            $service,
            $lastState->name(),
            $reason
        );

        return new static($message);
    }
}
