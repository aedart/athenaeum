<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Database Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DatabaseAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DatabaseTrait
{
    /**
     * Name of database
     *
     * @var string|null
     */
    protected string|null $database = null;

    /**
     * Set database
     *
     * @param string|null $name Name of database
     *
     * @return self
     */
    public function setDatabase(string|null $name): static
    {
        $this->database = $name;

        return $this;
    }

    /**
     * Get database
     *
     * If no database value set, method
     * sets and returns a default database.
     *
     * @see getDefaultDatabase()
     *
     * @return string|null database or null if no database has been set
     */
    public function getDatabase(): string|null
    {
        if (!$this->hasDatabase()) {
            $this->setDatabase($this->getDefaultDatabase());
        }
        return $this->database;
    }

    /**
     * Check if database has been set
     *
     * @return bool True if database has been set, false if not
     */
    public function hasDatabase(): bool
    {
        return isset($this->database);
    }

    /**
     * Get a default database value, if any is available
     *
     * @return string|null Default database value or null if no default value is available
     */
    public function getDefaultDatabase(): string|null
    {
        return null;
    }
}
