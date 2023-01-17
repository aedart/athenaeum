<?php

namespace Aedart\Redmine\Traits;

use Aedart\Contracts\Redmine\Connection;

/**
 * Connection Trait
 *
 * @see \Aedart\Contracts\Redmine\ConnectionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Traits
 */
trait ConnectionTrait
{
    /**
     * Redmine API Connection instance
     *
     * @var Connection|null
     */
    protected Connection|null $connection = null;

    /**
     * Set connection
     *
     * @param Connection|null $connection Redmine API Connection instance
     *
     * @return self
     */
    public function setConnection(Connection|null $connection): static
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get connection
     *
     * If no connection has been set, this method will
     * set and return a default connection, if any such
     * value is available
     *
     * @return Connection|null connection or null if none connection has been set
     */
    public function getConnection(): Connection|null
    {
        if (!$this->hasConnection()) {
            $this->setConnection($this->getDefaultConnection());
        }
        return $this->connection;
    }

    /**
     * Check if connection has been set
     *
     * @return bool True if connection has been set, false if not
     */
    public function hasConnection(): bool
    {
        return isset($this->connection);
    }

    /**
     * Get a default connection value, if any is available
     *
     * @return Connection|null A default connection value or Null if no default value is available
     */
    public function getDefaultConnection(): Connection|null
    {
        return null;
    }
}
