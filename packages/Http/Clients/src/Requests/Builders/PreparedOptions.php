<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use Aedart\Http\Clients\Traits\HttpClientTrait;

/**
 * Prepared Driver Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
class PreparedOptions implements HttpClientAware
{
    use HttpClientTrait;

    /**
     * The prepared driver options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * PreparedOptions constructor.
     *
     * @param Client $client
     * @param array $options [optional]
     */
    public function __construct(Client $client, array $options = [])
    {
        $this
            ->setHttpClient($client)
            ->setPreparedOptions($options);
    }

    /**
     * Set the prepared driver options
     *
     * @param array $options [optional]
     *
     * @return self
     */
    public function setPreparedOptions(array $options = [])
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Returns the prepared driver options
     *
     * @return array
     */
    public function getPreparedOptions(): array
    {
        return $this->options;
    }

    /**
     * Alias for getHttpClient
     *
     * @see getHttpClient
     *
     * @return Client
     */
    public function client(): Client
    {
        return $this->getHttpClient();
    }
}