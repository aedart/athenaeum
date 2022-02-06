<?php

namespace Aedart\Contracts\Support\Helpers\Database;

use Illuminate\Database\ConnectionInterface;

/**
 * Db Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Database
 */
interface DbAware
{
    /**
     * Set db
     *
     * @param ConnectionInterface|null $connection Database Connection instance
     *
     * @return self
     */
    public function setDb(ConnectionInterface|null $connection): static;

    /**
     * Get db
     *
     * If no db has been set, this method will
     * set and return a default db, if any such
     * value is available
     *
     * @see getDefaultDb()
     *
     * @return ConnectionInterface|null db or null if none db has been set
     */
    public function getDb(): ConnectionInterface|null;

    /**
     * Check if db has been set
     *
     * @return bool True if db has been set, false if not
     */
    public function hasDb(): bool;

    /**
     * Get a default db value, if any is available
     *
     * @return ConnectionInterface|null A default db value or Null if no default value is available
     */
    public function getDefaultDb(): ConnectionInterface|null;
}
