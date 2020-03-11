<?php

namespace Aedart\Contracts\Http\Clients;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Psr\Http\Client\ClientInterface;

/**
 * Http Client
 *
 * TODO: Dynamic methods available, e.g. builder ! Coming soon...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients
 */
interface Client extends
    ClientInterface,
    ContainerAware
{
    /**
     * Returns this Http Client's initial options
     *
     * @return array
     */
    public function getClientOptions(): array;

    /**
     * Get this Http Client's native driver
     *
     * @return mixed
     */
    public function driver();

    /**
     * Creates and returns a new Http Request Builder
     *
     * @return Builder
     */
    public function makeBuilder(): Builder;
}
