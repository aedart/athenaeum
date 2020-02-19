<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Sql Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\SqlAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait SqlTrait
{
    /**
     * A Structured Query Language (SQL) query
     *
     * @var string|null
     */
    protected ?string $sql = null;

    /**
     * Set sql
     *
     * @param string|null $query A Structured Query Language (SQL) query
     *
     * @return self
     */
    public function setSql(?string $query)
    {
        $this->sql = $query;

        return $this;
    }

    /**
     * Get sql
     *
     * If no "sql" value set, method
     * sets and returns a default "sql".
     *
     * @see getDefaultSql()
     *
     * @return string|null sql or null if no sql has been set
     */
    public function getSql(): ?string
    {
        if (!$this->hasSql()) {
            $this->setSql($this->getDefaultSql());
        }
        return $this->sql;
    }

    /**
     * Check if "sql" has been set
     *
     * @return bool True if "sql" has been set, false if not
     */
    public function hasSql(): bool
    {
        return isset($this->sql);
    }

    /**
     * Get a default "sql" value, if any is available
     *
     * @return string|null Default "sql" value or null if no default value is available
     */
    public function getDefaultSql(): ?string
    {
        return null;
    }
}
