<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Query Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\QueryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait QueryTrait
{
    /**
     * Query
     *
     * @var string|null
     */
    protected ?string $query = null;

    /**
     * Set query
     *
     * @param string|null $query Query
     *
     * @return self
     */
    public function setQuery(?string $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * If no "query" value set, method
     * sets and returns a default "query".
     *
     * @see getDefaultQuery()
     *
     * @return string|null query or null if no query has been set
     */
    public function getQuery() : ?string
    {
        if ( ! $this->hasQuery()) {
            $this->setQuery($this->getDefaultQuery());
        }
        return $this->query;
    }

    /**
     * Check if "query" has been set
     *
     * @return bool True if "query" has been set, false if not
     */
    public function hasQuery() : bool
    {
        return isset($this->query);
    }

    /**
     * Get a default "query" value, if any is available
     *
     * @return string|null Default "query" value or null if no default value is available
     */
    public function getDefaultQuery() : ?string
    {
        return null;
    }
}
