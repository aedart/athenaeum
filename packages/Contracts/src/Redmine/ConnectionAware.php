<?php

namespace Aedart\Contracts\Redmine;

/**
 * Connection Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Redmine
 */
interface ConnectionAware
{
    /**
     * Set connection
     *
     * @param Connection|null $connection Redmine API Connection instance
     *
     * @return self
     */
    public function setConnection(Connection|null $connection): static;

    /**
     * Get connection
     *
     * If no connection has been set, this method will
     * set and return a default connection, if any such
     * value is available
     *
     * @return Connection|null connection or null if none connection has been set
     */
    public function getConnection(): Connection|null;

    /**
     * Check if connection has been set
     *
     * @return bool True if connection has been set, false if not
     */
    public function hasConnection(): bool;

    /**
     * Get a default connection value, if any is available
     *
     * @return Connection|null A default connection value or Null if no default value is available
     */
    public function getDefaultConnection(): Connection|null;
}
