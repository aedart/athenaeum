<?php

namespace Aedart\Contracts\Redmine;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Psr\Http\Message\ResponseInterface;

/**
 * Redmine API Connection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
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
    public static function resolve(string|Connection|null $connection = null): Connection;

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

    /**
     * Mock (fake) the next response(s)
     *
     * Method is intended to for testing purposes only
     *
     * @param  ResponseInterface|ResponseInterface[]  $response
     *
     * @return self
     */
    public function mock(array|ResponseInterface $response): static;

    /**
     * Determine if next response should be mocked
     *
     * @return bool
     */
    public function mustMockNextResponse(): bool;

    /**
     * Returns mocked response(s), if any set
     *
     * @see mock()
     *
     * @return ResponseInterface[] Empty when no mocked responses have been set
     */
    public function getMockedResponse(): array;
}
