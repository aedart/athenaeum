<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Query Aware
 *
 * Component is aware of string "query"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface QueryAware
{
    /**
     * Set query
     *
     * @param string|null $query Query
     *
     * @return self
     */
    public function setQuery(string|null $query): static;

    /**
     * Get query
     *
     * If no query value set, method
     * sets and returns a default query.
     *
     * @see getDefaultQuery()
     *
     * @return string|null query or null if no query has been set
     */
    public function getQuery(): string|null;

    /**
     * Check if query has been set
     *
     * @return bool True if query has been set, false if not
     */
    public function hasQuery(): bool;

    /**
     * Get a default query value, if any is available
     *
     * @return string|null Default query value or null if no default value is available
     */
    public function getDefaultQuery(): string|null;
}
