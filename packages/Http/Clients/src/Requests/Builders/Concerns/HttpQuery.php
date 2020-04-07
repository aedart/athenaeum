<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder as Query;
use Aedart\Http\Clients\Requests\Query\Builder as QueryBuilder;

/**
 * Concerns Http Query
 *
 * @see Builder
 * @see Builder::withQuery
 * @see Builder::setQuery
 * @see Builder::hasQuery
 * @see Builder::getQuery
 * @see Builder::where
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpQuery
{
    /**
     * Http query builder for next request
     *
     * @var Query|null
     */
    protected ?Query $query = null;

    /**
     * @inheritdoc
     */
    public function query(): Query
    {
        if (isset($this->query)) {
            return $this->query;
        }

        return $this->query = $this->newQuery();
    }

    /**
     * @inheritdoc
     */
    public function newQuery(): Query
    {
        return new QueryBuilder(
            $this->resolveHttpQueryGrammar(),
            $this->getContainer()
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves the Http Query Grammar to be used
     *
     * @return string
     */
    protected function resolveHttpQueryGrammar(): string
    {
        return $this->getOption('grammar-profile') ?? 'default';
    }
}
