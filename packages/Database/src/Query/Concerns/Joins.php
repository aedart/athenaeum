<?php

namespace Aedart\Database\Query\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Concerns Query Joins
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Database\Query\Concerns
 */
trait Joins
{
    /**
     * Determine if query has a join expression to given table
     *
     * @param Builder|EloquentBuilder $query
     * @param string $table
     *
     * @return bool
     */
    public function hasJoinTo(Builder|EloquentBuilder $query, string $table): bool
    {
        // Resolve native query instance...
        if ($query instanceof Relation) {
            $query = $query->getBaseQuery();
        } elseif ($query instanceof EloquentBuilder) {
            $query = $query->getQuery();
        }

        if (empty($query->joins)) {
            return false;
        }

        foreach ($query->joins as $join) {
            if ($join->table === $table) {
                return true;
            }
        }

        return false;
    }

    /**
     * Adds join expression, if query has not already a join expression to table
     *
     * @see \Illuminate\Contracts\Database\Query\Builder::join
     *
     * @param Builder|EloquentBuilder $query
     * @param  string  $table
     * @param  callable|string  $first
     * @param  string|null  $operator [optional]
     * @param  string|null  $second [optional]
     * @param  string  $type [optional]
     * @param  bool  $where [optional]
     *
     * @return Builder|EloquentBuilder
     */
    public function safeJoin(
        Builder|EloquentBuilder $query,
        string $table,
        callable|string $first,
        string|null $operator = null,
        string|null $second = null,
        string $type = 'inner',
        bool $where = false
    ): Builder|EloquentBuilder {
        if ($this->hasJoinTo($query, $table)) {
            return $query;
        }

        return $query
            ->join($table, $first, $operator, $second, $type, $where);
    }
}
