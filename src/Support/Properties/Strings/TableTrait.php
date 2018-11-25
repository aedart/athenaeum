<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Table Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TableAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TableTrait
{
    /**
     * Name of table
     *
     * @var string|null
     */
    protected $table = null;

    /**
     * Set table
     *
     * @param string|null $name Name of table
     *
     * @return self
     */
    public function setTable(?string $name)
    {
        $this->table = $name;

        return $this;
    }

    /**
     * Get table
     *
     * If no "table" value set, method
     * sets and returns a default "table".
     *
     * @see getDefaultTable()
     *
     * @return string|null table or null if no table has been set
     */
    public function getTable() : ?string
    {
        if ( ! $this->hasTable()) {
            $this->setTable($this->getDefaultTable());
        }
        return $this->table;
    }

    /**
     * Check if "table" has been set
     *
     * @return bool True if "table" has been set, false if not
     */
    public function hasTable() : bool
    {
        return isset($this->table);
    }

    /**
     * Get a default "table" value, if any is available
     *
     * @return string|null Default "table" value or null if no default value is available
     */
    public function getDefaultTable() : ?string
    {
        return null;
    }
}
