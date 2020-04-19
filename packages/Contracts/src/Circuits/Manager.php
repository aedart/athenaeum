<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;

/**
 * Circuit Breaker Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface Manager
{
    /**
     * Create or obtain Circuit Breaker
     *
     * @param string|null $profile [optional] Name of Circuit Breaker profile to obtain or create
     * @param array $options [optional] Circuit Breaker options
     *
     * @return CircuitBreaker
     *
     * @throws ProfileNotFoundException
     */
    public function profile(?string $profile = null, array $options = []): CircuitBreaker;
}
