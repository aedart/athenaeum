<?php

namespace Aedart\Http\Clients\Drivers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Base Http Client
 *
 * Abstraction for Http Clients
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Drivers
 */
abstract class BaseClient implements Client
{
    /**
     * Invokes a method on this Http Client's Request Builder
     *
     * @see Builder
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this->makeBuilder()->{$method}(...$arguments);
    }
}