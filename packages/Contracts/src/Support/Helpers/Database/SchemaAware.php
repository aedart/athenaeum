<?php

namespace Aedart\Contracts\Support\Helpers\Database;

use Illuminate\Database\Schema\Builder;

/**
 * Schema Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Database
 */
interface SchemaAware
{
    /**
     * Set schema
     *
     * @param Builder|null $builder Database Schema Builder instance
     *
     * @return self
     */
    public function setSchema(Builder|null $builder): static;

    /**
     * Get schema
     *
     * If no schema has been set, this method will
     * set and return a default schema, if any such
     * value is available
     *
     * @see getDefaultSchema()
     *
     * @return Builder|null schema or null if none schema has been set
     */
    public function getSchema(): Builder|null;

    /**
     * Check if schema has been set
     *
     * @return bool True if schema has been set, false if not
     */
    public function hasSchema(): bool;

    /**
     * Get a default schema value, if any is available
     *
     * @return Builder|null A default schema value or Null if no default value is available
     */
    public function getDefaultSchema(): Builder|null;
}
