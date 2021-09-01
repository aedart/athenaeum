<?php

namespace Aedart\Redmine\Relations;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Relations\ResourceRelation as ResourceRelationInterface;
use Aedart\Contracts\Redmine\Resource;

/**
 * Resource Relation
 *
 * Base abstraction for a resource relation
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Relations
 */
abstract class ResourceRelation implements ResourceRelationInterface
{
    /**
     * The parent resource
     *
     * @var Resource
     */
    protected Resource $parent;

    /**
     * Class path to the related resource
     *
     * @var string|Resource Class path
     */
    protected $related;

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
    protected $connection = null;

    /**
     * ResourceRelation
     *
     * @param Resource $parent
     * @param string|Resource $related Class path
     */
    public function __construct(Resource $parent, $related)
    {
        $this->parent = $parent;
        $this->related = $related;

        // Set default connection
        $this->usingConnection($parent->getConnection());
    }

    /**
     * @inheritDoc
     */
    public function include(array $include)
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
    public function filter(callable $filter)
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
    public function usingConnection($connection = null)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @inheritdoc
     */
    public function parent(): Resource
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function related()
    {
        if (!is_string($this->related)) {
            return get_class($this->related);
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
        return function (Builder $request, Resource $resource) {

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
