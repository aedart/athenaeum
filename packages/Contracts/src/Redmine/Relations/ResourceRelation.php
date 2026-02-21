<?php

namespace Aedart\Contracts\Redmine\Relations;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\Connection;
use Throwable;

/**
 * Resource Relation
 *
 * @template T
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Redmine\Relations
 */
interface ResourceRelation
{
    /**
     * Fetch the related resource
     *
     * @return T
     *
     * @throws Throwable
     */
    public function fetch();

    /**
     * Include one or more associated data
     *
     * @param string[] $include List of associated data to include
     *
     * @return self
     */
    public function include(array $include): static;

    /**
     * Returns list of associated data to be included
     *
     * @return string[]
     */
    public function getIncludes(): array;

    /**
     * Add a filter to be applied
     *
     * @param callable(Builder $request, ApiResource $resource): Builder $filter
     *                          Callback that applies filters on related resource's Request {@see Builder}.
     *                          The callback MUST return a valid {@see Builder}
     *
     * @return self
     */
    public function filter(callable $filter): static;

    /**
     * Returns the filters to be applied onto
     * the related resource's request.
     *
     * @return array<callable(Builder $request, ApiResource $resource): Builder>[]
     */
    public function getFilters(): array;

    /**
     * Use given connection for when obtaining related resource
     *
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return self
     */
    public function usingConnection(string|Connection|null $connection = null): static;

    /**
     * Get the connection to be used when obtaining related resource
     *
     * @return string|Connection|null Defaults to {@see parent} resource's connection
     */
    public function getConnection(): string|Connection|null;

    /**
     * Get the parent resource
     *
     * @return ApiResource
     */
    public function parent(): ApiResource;

    /**
     * Get the related resource
     *
     * @return ApiResource|class-string<ApiResource> Class path
     */
    public function related(): ApiResource|string;
}
