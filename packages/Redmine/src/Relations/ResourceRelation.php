<?php

namespace Aedart\Redmine\Relations;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Relations\ResourceRelation as ResourceRelationInterface;

/**
 * Resource Relation
 *
 * Base abstraction for a resource relation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Relations
 */
abstract class ResourceRelation implements ResourceRelationInterface
{
    /**
     * The parent resource
     *
     * @var ApiResource
     */
    protected ApiResource $parent;

    /**
     * Class path to the related resource
     *
     * @var string|ApiResource Class path
     */
    protected string|ApiResource $related;

    /**
     * List of associated data to be included
     *
     * @var string[]
     */
    protected array $includes = [];

    /**
     * Filters to be applied onto the related resource's request.
     *
     * @var callable[]
     */
    protected array $filters = [];

    /**
     * Connection to be used when obtaining related resource
     *
     * @var string|Connection|null
     */
    protected string|Connection|null $connection = null;

    /**
     * ResourceRelation
     *
     * @param ApiResource $parent
     * @param string|ApiResource $related Class path or Api resource instance
     */
    public function __construct(ApiResource $parent, string|ApiResource $related)
    {
        $this->parent = $parent;
        $this->related = $related;

        // Set default connection
        $this->usingConnection($parent->getConnection());
    }

    /**
     * @inheritDoc
     */
    public function include(array $include): static
    {
        $this->includes = array_merge(
            $this->includes,
            $include
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIncludes(): array
    {
        return $this->includes;
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $filter): static
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @inheritDoc
     */
    public function usingConnection(string|Connection|null $connection = null): static
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConnection(): string|Connection|null
    {
        return $this->connection;
    }

    /**
     * @inheritdoc
     */
    public function parent(): ApiResource
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function related(): ApiResource|string
    {
        if (!is_string($this->related)) {
            return $this->related::class;
        }

        return $this->related;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Wraps all includes and filters into a single filter callback
     *
     * @return callable
     */
    protected function wrapFilters(): callable
    {
        return function (Builder $request, ApiResource $resource) {
            // Apply includes
            $applied = $resource->applyIncludes(
                $this->getIncludes(),
                $request
            );

            // Apply filter callbacks
            $filters = $this->getFilters();
            foreach ($filters as $callback) {
                $applied = $callback($applied, $resource);

                // (Re)set the applied request builder to be provided builder,
                // in case that nothing was returned by the filter callback!
                if (!isset($applied)) {
                    $applied = $request;
                }
            }

            return $applied;
        };
    }
}
