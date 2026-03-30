<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Support\Helpers\Logging\LogTrait;
use Illuminate\Support\Str;
use Psr\Http\Message\MessageInterface;

/**
 * Concerns Logging
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Logging
{
    use LogTrait;

    /**
     * Request / Response logging callback
     *
     * @var callable(Type $type, MessageInterface $message, Builder $builder): (void)|null
     */
    protected $logCallback = null;

    /**
     * @inheritDoc
     */
    public function log(callable|null $callback = null): static
    {
        $callback = $callback ?? $this->makeLogCallback();

        return $this->setLogCallback($callback);
    }

    /**
     * @inheritDoc
     */
    public function logCallback(): callable
    {
        if (!isset($this->logCallback)) {
            return $this->makeNullLogCallback();
        }

        return $this->logCallback;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set the request / response logging callback to be
     * applied.
     *
     * @param  callable(Type $type, MessageInterface $message, Builder $builder): void  $callback
     *
     * @return Builder
     */
    protected function setLogCallback(callable $callback): static
    {
        $this->logCallback = $callback;

        return $this;
    }

    /**
     * Returns a "null" log callback method.
     *
     * @return callable
     */
    protected function makeNullLogCallback(): callable
    {
        return function (Type $type, MessageInterface $message, Builder $builder) {
            // N/A...
        };
    }

    /**
     * Returns a default logging callback
     *
     * @return callable
     */
    protected function makeLogCallback(): callable
    {
        return function (Type $type, MessageInterface $message, Builder $builder) {
            $this->getLog()->info(
                Str::ucfirst($type->value),
                $this->makeDebugContext($type, $message)
            );
        };
    }
}
