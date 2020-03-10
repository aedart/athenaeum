<?php

namespace Aedart\Http\Clients\Drivers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * Http Client specific options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * BaseClient constructor.
     *
     * @param array $options [optional]
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge(
            $this->initialOptions(),
            $options
        );
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->send($request);
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
}
