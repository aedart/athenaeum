<?php

namespace Aedart\Circuits\Concerns;

/**
 * Concerns Context
 *
 * @see \Aedart\Contracts\Circuits\Exceptions\HasContext
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Concerns
 */
trait Context
{
    /**
     * Arbitrary data associated with exception
     * or failure
     *
     * @var array
     */
    protected array $context = [];

    /**
     * Arbitrary data associated with exception
     * or failure
     *
     * @return mixed[]
     */
    public function context(): array
    {
        return $this->context;
    }

    /**
     * Set arbitrary data associated with exception
     * or failure
     *
     * @param array $context [optional]
     *
     * @return self
     */
    protected function setContext(array $context = [])
    {
        $this->context = $context;

        return $this;
    }
}
