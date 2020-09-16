<?php

namespace Aedart\Http\Clients\Drivers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Http\Clients\Requests\Handlers\QueueHandler;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Container\Container;

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
    use ContainerTrait;

    /**
     * Http Client specific options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * BaseClient constructor.
     *
     * @param Container $container
     * @param array $options [optional]
     */
    public function __construct(Container $container, array $options = [])
    {
        $this->setContainer($container);

        $this->options = array_merge(
            $this->initialOptions(),
            $options
        );
    }

    /**
     * Returns evt. initial options for this Http Client
     *
     * These options can be overwritten via the regular options
     * given to this client.
     *
     * @return array
     */
    public function initialOptions(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getClientOptions(): array
    {
        return $this->options;
    }

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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a new handler that is able to process middleware for
     * outgoing request and incoming response.
     *
     * @see Handler
     * @see Middleware
     *
     * @param  Handler  $fallbackHandler The fallback handler
     *
     * @return Handler
     */
    protected function makeMiddlewareHandler(Handler $fallbackHandler): Handler
    {
        return new QueueHandler($fallbackHandler);
    }
}
