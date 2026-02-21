<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Messages\Exceptions\SerializationException;
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Psr\Http\Message\MessageInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Concerns Debugging
 *
 * @see Builder
 * @see Builder::debug
 * @see Builder::dd
 * @see Builder::debugCallback
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Debugging
{
    use HttpSerializerFactoryTrait;

    /**
     * Request / Response callback to be applied.
     *
     * @var callable(string $type, MessageInterface $message, Builder $builder): (void)|null
     */
    protected $debugCallback = null;

    /**
     * @inheritDoc
     */
    public function debug(callable|null $callback = null): static
    {
        $callback = $callback ?? $this->makeDumpCallback();

        return $this->setDebugCallback($callback);
    }

    /**
     * @inheritDoc
     */
    public function dd(callable|null $callback = null): static
    {
        $callback = $callback ?? $this->makeDumpAndDieCallback();

        return $this->setDebugCallback($callback);
    }

    /**
     * @inheritdoc
     */
    public function debugCallback(): callable
    {
        if (!isset($this->debugCallback)) {
            return $this->makeNullDebugCallback();
        }

        return $this->debugCallback;
    }

    /**
     * Creates a context array for given Http Message
     *
     * @param string $type E.g. request or response
     * @param  MessageInterface  $message
     * @return array
     *
     * @throws SerializationException
     */
    public function makeDebugContext(string $type, MessageInterface $message): array
    {
        $serialized = $this
            ->getHttpSerializerFactory()
            ->make($message)
            ->toArray();

        return [ $type => $serialized ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set the request / response debug callback to be
     * applied.
     *
     * @param  callable(string $type, MessageInterface $message, Builder $builder): void  $callback
     *
     * @return Builder
     */
    protected function setDebugCallback(callable $callback): Builder
    {
        $this->debugCallback = $callback;

        return $this;
    }

    /**
     * Returns a "null" debug callback method.
     *
     * @return callable(string $type, MessageInterface $message, Builder $builder): void
     */
    protected function makeNullDebugCallback(): callable
    {
        return function (string $type, MessageInterface $message, Builder $builder): void {
            // N/A...
        };
    }

    /**
     * Returns a default "dump" callback
     *
     * @return callable(string $type, MessageInterface $message, Builder $builder): void
     */
    protected function makeDumpCallback(): callable
    {
        return function (string $type, MessageInterface $message, Builder $builder): void {
            VarDumper::dump($this->makeDebugContext($type, $message));
        };
    }

    /**
     * Returns a default "dump and die" callback
     *
     * @return callable(string $type, MessageInterface $message, Builder $builder): void
     */
    protected function makeDumpAndDieCallback(): callable
    {
        return function (string $type, MessageInterface $message, Builder $builder): void {
            // Obtain reference to var dumper handler.
            $originalHandler = VarDumper::setHandler(null);
            VarDumper::setHandler($originalHandler);

            // Dump...
            VarDumper::dump($this->makeDebugContext($type, $message));

            // Exist script, if original handler is null. Otherwise,
            // we have to assume that something else is going on, e.g.
            // a running test or other special kind of debugging.
            if (null === $originalHandler) {
                exit(1);
            }
        };
    }
}
