<?php

namespace Aedart\Redmine\Relations;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\Exceptions\RedmineException as RedmineExceptionInterface;
use Aedart\Contracts\Redmine\TraversableResults;
use Aedart\Redmine\Exceptions\RelationException;
use Aedart\Utils\Str;
use ReflectionClass;
use Throwable;

/**
 * Has Many Resources Relation
 *
 * @template T
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Relations
 */
class HasMany extends ResourceRelation
{
    /**
     * Name of the filter key to be applied on
     * related resource
     *
     * @var string|null
     */
    protected string|null $filterKey = null;

    /**
     * The parent resource's primary key value
     *
     * @var string|int|null
     */
    protected string|int|null $ownKeyValue = null;

    /**
     * Pagination limit
     *
     * @var int
     */
    protected int $limit = 10;

    /**
     * Pagination offset
     *
     * @var int
     */
    protected int $offset = 0;

    /**
     * Creates new has many resource relation instance
     *
     * @param  ApiResource  $parent
     * @param  string|ApiResource  $related Class path or Api resource instance
     * @param  string|null  $filterKey  [optional] name of the filtering key to be applied
     *                                  when obtaining the related resources
     */
    public function __construct(ApiResource $parent, string|ApiResource $related, string|null $filterKey = null)
    {
        parent::__construct($parent, $related);

        $this->filterKey($filterKey);
    }

    /**
     * @inheritDoc
     */
    public function fetch()
    {
        // Resolve the own key value - or fail if no value obtained
        $value = $this->key();
        if (!isset($value)) {
            throw new RelationException('Unable to fetch relation, own key (parent resource primary key) could not be resolved or was not specified');
        }

        // Build the constraint filter and add it to the filters
        $this->filter(
            $this->buildConstraintFilter($this->getFilterKey(), $value)
        );

        // Finally, fetch the related resources
        return $this->related()::fetchMultiple(
            $this->wrapFilters(),
            $this->getLimit(),
            $this->getOffset(),
            $this->getConnection()
        );
    }

    /**
     * Fetch all resources
     *
     * @see \Aedart\Contracts\Redmine\ApiResource::all
     *
     * @param int $size [optional] The "pool" size - maximum limit of results to fetch per request
     *
     * @return TraversableResults<T>
     *
     * @throws RedmineExceptionInterface
     * @throws Throwable
     */
    public function fetchAll(int $size = 10): TraversableResults
    {
        // Resolve the own key value - or fail if no value obtained
        $value = $this->key();
        if (!isset($value)) {
            throw new RelationException('Unable to fetch relation, own key (parent resource primary key) could not be resolved or was not specified');
        }

        // Build the constraint filter and add it to the filters
        $this->filter(
            $this->buildConstraintFilter($this->getFilterKey(), $value)
        );

        return $this->related()::all(
            $this->wrapFilters(),
            $size,
            $this->getConnection()
        );
    }

    /**
     * Set the max. amount of results to be returned
     *
     * @param int $limit [optional]
     *
     * @return self
     */
    public function limit(int $limit = 10): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the max. amount of results to be returned
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Set the pagination offset
     *
     * @param int $offset [optional]
     *
     * @return self
     */
    public function offset(int $offset = 0): static
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Get the pagination offset
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Set the filtering key value to be used
     *
     * @param string|int|null $value [optional]
     *
     * @return self
     */
    public function ownKey(string|int|null $value = null): static
    {
        $this->ownKeyValue = $value;

        return $this;
    }

    /**
     * Returns the filtering key value to be used
     *
     * Method will default to parent resource's primary
     * key value, if none was previously set
     *
     * @return int|string|null
     */
    public function key(): int|string|null
    {
        if (!isset($this->ownKeyValue)) {
            $this->ownKey($this->parent()->id());
        }

        return $this->ownKeyValue;
    }

    /**
     * Set the name of the filtering key to be applied when obtaining
     * the related resources
     *
     * @param string|null $filterKey [optional]
     *
     * @return self
     */
    public function filterKey(string|null $filterKey = null): static
    {
        $this->filterKey = $filterKey;

        return $this;
    }

    /**
     * Get the name of the filtering key to be applied when obtaining
     * the related resources
     *
     * If no previous filtering key was set, then method will guess
     * a filtering key.
     *
     * @see guessFilterKey
     *
     * @return string
     */
    public function getFilterKey(): string
    {
        if (!isset($this->filterKey)) {
            $this->filterKey($this->guessFilterKey());
        }

        return $this->filterKey;
    }

    /**
     * Guesses a filtering key name
     *
     * @return string
     */
    public function guessFilterKey(): string
    {
        $name = (new ReflectionClass($this->parent()))->getShortName();

        return Str::snake($name) . '_id';
    }

    /**
     * Builds this relation's constraint filter callback
     *
     * @param string $key
     * @param string|int $value
     *
     * @return callable
     */
    public function buildConstraintFilter(string $key, string|int $value): callable
    {
        return function (Builder $request) use ($key, $value) {
            return $request->where($key, $value);
        };
    }
}
