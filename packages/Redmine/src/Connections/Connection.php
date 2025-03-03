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
 * @author Alin Eugen Deac <aedart@gmail.com>
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
     * @var ResponseInterface[]
     */
    protected array $mockedResponse = [];

    /**
     * General failed expectation handler
     *
     * @var callable|null
     */
    protected $failedExpectationHandler = null;

    /**
     * Connection
     *
     * @param string|null $connection [optional] Profile name. Defaults to a default connection
     *                                profile when none is given
     */
    public function __construct(string|null $connection = null)
    {
        $this->profile = $connection ?? $this->defaultProfile();
    }

    /**
     * @inheritDoc
     */
    public static function resolve(string|ConnectionInterface|null $connection = null): ConnectionInterface
    {
        if ($connection instanceof ConnectionInterface) {
            return $connection;
        }

        return new static($connection);
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
    public function getDefaultHttpClient(): Client|null
    {
        $httpProfile = $this->option('http_client');

        try {
            return $this->getHttpClientsManager()->fresh($httpProfile, $this->httpClientOptions());
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
    public function mock(array|ResponseInterface $response): static
    {
        if (!is_array($response)) {
            $response = [ $response ];
        }

        $this->mockedResponse = $response;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mustMockNextResponse(): bool
    {
        return !empty($this->mockedResponse);
    }

    /**
     * @inheritDoc
     */
    public function getMockedResponse(): array
    {
        return $this->mockedResponse;
    }

    /**
     * Set a general expectation handler for this connection
     *
     * @param callable|null $handler
     *
     * @return self
     */
    public function useFailedExpectationHandler(callable|null $handler): static
    {
        $this->failedExpectationHandler = $handler;

        return $this;
    }

    /**
     * Determine if an expectation handler has been set for this connection
     *
     * @return bool
     */
    public function hasFailedExpectationHandler(): bool
    {
        return isset($this->failedExpectationHandler) && is_callable($this->failedExpectationHandler);
    }

    /**
     * Returns this connection's general failed expectation handler
     *
     * @return callable|null
     */
    public function failedExpectationHandler(): callable|null
    {
        return $this->failedExpectationHandler;
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
            $output['handler'] = HandlerStack::create(new MockHandler($this->getMockedResponse()));
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
     * @param mixed $default [optional]
     *
     * @return mixed
     */
    protected function option(string $key, mixed $default = null): mixed
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
