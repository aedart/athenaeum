<?php

namespace Aedart\Redmine\Connections;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Redmine\Connection as ConnectionInterface;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Redmine\Exceptions\InvalidConnection;
use Aedart\Support\Helpers\Config\ConfigTrait;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

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
     * Mocked response, if any was set
     *
     * @var ResponseInterface|null
     */
    protected ?ResponseInterface $mockedResponse = null;

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
        $httpProfile = $this->option('http_client');

        try {
            return $this->getHttpClientsManager()->profile($httpProfile, $this->httpClientOptions());
        } catch (ProfileNotFoundException $e) {
            throw new InvalidConnection(sprintf(
                'Unable to resolve Redmine connection "%s". Http Client profile "%s" does not exist',
                $this->getProfile(),
                $httpProfile
            ), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function mock(ResponseInterface $response): ConnectionInterface
    {
        $this->mockedResponse = $response;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mustMockNextResponse(): bool
    {
        return isset($this->mockedResponse);
    }

    /**
     * @inheritDoc
     */
    public function getMockedResponse(): ?ResponseInterface
    {
        return $this->mockedResponse;
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
        $output = [
            // Authentication headers for Redmine
            'headers' => [
                static::$authenticationHeader => $this->option('authentication')
            ]
        ];

        // Handler Stack / Mocked response
        if ($this->mustMockNextResponse()) {
            $output['handler'] = HandlerStack::create(new MockHandler([ $this->getMockedResponse() ]));
        }

        return $output;
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
        $profile = $this->getProfile();
        $config = $this->getConfig();

        $prefix = "redmine.connections.{$profile}";
        if (!$config->has($prefix)) {
            throw new InvalidConnection(sprintf('Redmine connection "%s" does not exist', $profile));
        }

        return $config->get("{$prefix}.{$key}", $default);
    }
}
