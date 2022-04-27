<?php

namespace Aedart\Support\Helpers\Database;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

/**
 * Db Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Database\DbAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Database
 */
trait DbTrait
{
    /**
     * Database Connection instance
     *
     * @var ConnectionInterface|null
     */
    protected ConnectionInterface|null $db = null;

    /**
     * Set db
     *
     * @param ConnectionInterface|null $connection Database Connection instance
     *
     * @return self
     */
    public function setDb(ConnectionInterface|null $connection): static
    {
        $this->db = $connection;

        return $this;
    }

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
    public function getDb(): ConnectionInterface|null
    {
        if (!$this->hasDb()) {
            $this->setDb($this->getDefaultDb());
        }
        return $this->db;
    }

    /**
     * Check if db has been set
     *
     * @return bool True if db has been set, false if not
     */
    public function hasDb(): bool
    {
        return isset($this->db);
    }

    /**
     * Get a default db value, if any is available
     *
     * @return ConnectionInterface|null A default db value or Null if no default value is available
     */
    public function getDefaultDb(): ConnectionInterface|null
    {
        $manager = DB::getFacadeRoot();
        if (isset($manager)) {
            return $manager->connection();
        }
        return $manager;
    }
}
