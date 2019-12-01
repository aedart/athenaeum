<?php

namespace Aedart\Support\Helpers\Database;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Schema Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Database\SchemaAware;
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Database
 */
trait SchemaTrait
{
    /**
     * Database Schema Builder instance
     *
     * @var Builder|null
     */
    protected ?Builder $schema = null;

    /**
     * Set schema
     *
     * @param Builder|null $builder Database Schema Builder instance
     *
     * @return self
     */
    public function setSchema(?Builder $builder)
    {
        $this->schema = $builder;

        return $this;
    }

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
    public function getSchema(): ?Builder
    {
        if (!$this->hasSchema()) {
            $this->setSchema($this->getDefaultSchema());
        }
        return $this->schema;
    }

    /**
     * Check if schema has been set
     *
     * @return bool True if schema has been set, false if not
     */
    public function hasSchema(): bool
    {
        return isset($this->schema);
    }

    /**
     * Get a default schema value, if any is available
     *
     * @return Builder|null A default schema value or Null if no default value is available
     */
    public function getDefaultSchema(): ?Builder
    {
        $manager = DB::getFacadeRoot();
        if (isset($manager) && ! is_null($manager->connection())) {
            return Schema::getFacadeRoot();
        }
        return $manager;
    }
}
