<?php

namespace Aedart\Contracts\Circuits\States;

use Aedart\Contracts\Utils\Enums\Concerns;
use Aedart\Contracts\Utils\Enums\HasDefault;
use JsonSerializable;

/**
 * Circuit Breaker State Identifier
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Circuits\States
 */
enum Identifier: int implements
    HasDefault,
    JsonSerializable
{
    use Concerns\BackedEnums;

    /**
     * Closed state identifier - initial state
     *
     * The success state - the circuit breaker has
     * not reached its failure threshold.
     */
    case CLOSED = 0;

    /**
     * Open state identifier
     *
     * This is the failure state - the circuit breaker has
     * tripped, because the failure threshold has been reached.
     */
    case OPEN = 2;

    /**
     * Half-open state identifier
     *
     * In this state, a single request (or action) is attempted.
     * If that request or action succeeds, then the state must
     * be changed to {@see Identifier::CLOSED}, otherwise the state must
     * change back to {@see Identifier::OPEN}.
     */
    case HALF_OPEN = 4;

    /**
     * @inheritDoc
     */
    public static function default(): self
    {
        return self::CLOSED;
    }

    /**
     * Returns the name (label) of this identifier
     *
     * @return string
     */
    public function name(): string
    {
        return match ($this) {
            self::CLOSED => 'closed',
            self::OPEN => 'open',
            self::HALF_OPEN => 'half open',
        };
    }
}
