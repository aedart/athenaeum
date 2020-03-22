<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Http Method
 *
 * @see Builder
 * @see Builder::withMethod
 * @see Builder::getMethod
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpMethod
{
    /**
     * The http method to use
     *
     * @var string
     */
    protected string $method = 'GET';

    /**
     * Set the Http method, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     *
     * @param string $method
     *
     * @return self
     */
    public function withMethod(string $method): Builder
    {
        $this->method = strtoupper(trim($method));

        return $this;
    }

    /**
     * Returns the Http method, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
