<?php

namespace Aedart\Contracts\Redmine;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use Aedart\Contracts\Redmine\Exceptions\ConnectionException;

/**
 * Redmine API Connection
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Redmine
 */
interface Connection extends HttpClientAware
{
    /**
     * Resolve the given connection
     *
     * @param string|Connection|null $connection [optional] Profile name or connection instance.
     *                                           If none is provided, then the connection will
     *                                           default to a default profile.
     *
     * @return Connection
     *
     * @throws ConnectionException
     */
    public static function resolve($connection = null): Connection;

    /**
     * Returns the Http Client for this connection
     *
     * @return Client
     */
    public function client(): Client;

    /**
     * Returns the connection profile name
     *
     * @return string
     */
    public function getProfile(): string;
}
