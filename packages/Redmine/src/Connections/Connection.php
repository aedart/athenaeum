<?php

namespace Aedart\Redmine\Connections;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Redmine\Connection as ConnectionInterface;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Redmine\Exceptions\InvalidConnection;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Redmine API Connection
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Connections
 */
class Connection implements ConnectionInterface
{
    use HttpClientsManagerTrait;
    use HttpClientTrait;
    use ConfigTrait;

    /**
     * Name of the connection profile
     *
     * @var string
     */
    protected string $profile;

    /**
     * Name of Redmine's authentication header
     *
     * @var string
     */
    protected static string $authenticationHeader = 'X-Redmine-API-Key';

    /**
     * Connection
     *
     * @param string|null $connection [optional] Profile name. Defaults to a default connection
     *                                profile when none is given
     */
    public function __construct(?string $connection = null)
    {
        $this->profile = $connection ?? $this->defaultProfile();
    }

    /**
     * @inheritDoc
     */
    public static function resolve($connection = null): ConnectionInterface
    {
        if ($connection instanceof ConnectionInterface) {
            return $connection;
        }

        if (is_string($connection) || is_null($connection)) {
            return new static($connection);
        }

        throw new InvalidConnection('Connection must be a valid profile name, Connection instance or null');
    }

    /**
     * @inheritDoc
     */
    public function client(): Client
    {
        return $this->getHttpClient();
    }

    /**
     * @inheritDoc
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * {@inheritDoc}
     *
     * @throws InvalidConnection
     */
    public function getDefaultHttpClient(): ?Client
    {
        try {
            $profile = $this->option('http_client');

            return $this->getHttpClientsManager()->profile($profile, $this->httpClientOptions());
        } catch (ProfileNotFoundException $e) {
            throw new InvalidConnection(sprintf('Unable to resolve Redmine connection "%s"', $this->profile), $e->getCode(), $e);
        }
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Http Client options
     *
     * @return array
     */
    protected function httpClientOptions(): array
    {
        return [
            'headers' => [
                static::$authenticationHeader => $this->option('authentication')
            ]
        ];
    }

    /**
     * Returns a default connection profile name
     *
     * @return string
     */
    protected function defaultProfile(): string
    {
        return $this->getConfig()->get('redmine.default');
    }

    /**
     * Returns an option for the connection profile
     *
     * @param string $key
     * @param mixed|null $default [optional]
     *
     * @return mixed
     */
    protected function option(string $key, $default = null)
    {
        $profile = $this->profile;
        return $this->getConfig()->get("redmine.connections.{$profile}.{$key}", $default);
    }
}
