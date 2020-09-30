<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Debugging
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Debugging
{
    /**
     * State whether or not to dump next request / response
     *
     * @var bool
     */
    protected bool $mustDebug = false;

    /**
     * State whether or not to dump next  next request / response
     * and exist script.
     *
     * @var bool
     */
    protected bool $mustDumpAndDie = false;

    /**
     * @inheritDoc
     */
    public function debug(): Builder
    {
        $this->mustDebug = true;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mustDebug(): bool
    {
        return $this->mustDebug;
    }

    /**
     * @inheritDoc
     */
    public function dd(): Builder
    {
        $this->mustDumpAndDie = true;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mustDumpAndDie(): bool
    {
        return $this->mustDumpAndDie;
    }
}
