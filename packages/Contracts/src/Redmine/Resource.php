<?php

namespace Aedart\Contracts\Redmine;

use Aedart\Contracts\Dto;
use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Contracts\Redmine\Exceptions\RedmineException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Redmine Resource
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Redmine
 */
interface Resource extends Dto,
   ConnectionAware
{
    /**
     * Creates a new resource instance
     *
     * @param array $data [optional]
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws Throwable
     */
    public static function make(array $data = [], $connection = null);

    /**
     * Returns Redmine resource name in plural form
     * E.g. issues, projects, relations, etc.
     *
     * @see https://www.redmine.org/projects/redmine/wiki/rest_api
     *
     * @return string
     */
    public function resourceName(): string;

    /**
     * Returns Redmine resource name in singular form
     * E.g. issue, project, relation, etc.
     *
     * @see resourceName
     *
     * @return string
     */
    public function resourceNameSingular(): string;

    /**
     * Fetch list of resources
     *
     * @param int $limit [optional]
     * @param int $offset [optional]
     * @param string[] $include [optional] List of associated data to include
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return PaginatedResults<static>|static[]
     *
     * @throws JsonException
     * @throws Throwable
     */
    public static function list(
        int $limit = 10,
        int $offset = 0,
        array $include = [],
        $connection = null
    ): PaginatedResults;

    /**
     * Finds resource that matches given id
     *
     * @param string|int $id Redmine resource id
     * @param string[] $include [optional] List of associated data to include
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static|null
     *
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    public static function find($id, array $include = [], $connection = null);

    /**
     * Finds resource that matches given id or fails
     *
     * @param string|int $id Redmine resource id
     * @param string[] $include [optional] List of associated data to include
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    public static function findOrFail($id, array $include = [], $connection = null);

    /**
     * Fetch a single resource, with given filters or conditions set
     *
     * Example:
     * <pre>
     *      $project = Project::fetch(42, function($request) {
     *          return $request->include(['trackers']);
     *      });
     * </pre>
     *
     * @param string|int $id Redmine resource id
     * @param callable|null $filters [optional] Callback that applies filters on the given Request {@see Builder}.
     *                          The callback MUST return a valid {@see Builder}
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws RedmineException If filters callback does not return a valid Request Builder
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    public static function fetch($id, ?callable $filters = null, $connection = null);

    /**
     * Fetch multiple resources, with given filters or conditions set.
     * Method will automatically perform paginated request.
     *
     * Example:
     * <pre>
     *      $projects = Project::fetchMultiple(function($request) {
     *          return $request->include(['trackers']);
     *      }, 5, 10);
     * </pre>
     *
     * @param callable|null $filters [optional] Callback that applies filters on the given Request {@see Builder}.
     *                               The callback MUST return a valid {@see Builder}
     * @param int $limit [optional]
     * @param int $offset [optional]
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return PaginatedResults<static>|static[]
     *
     * @throws RedmineException If filters callback does not return a valid Request Builder
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    public static function fetchMultiple(
        ?callable $filters = null,
        int $limit = 10,
        int $offset = 0,
        $connection = null
    ): PaginatedResults;

    /**
     * Paginate the given request
     *
     * @param  Builder  $request
     * @param int $limit [optional]
     * @param int $offset [optional]
     *
     * @return PaginatedResults<static>|static[]
     *
     * @throws JsonException
     * @throws Throwable
     */
    public function paginate(Builder $request, int $limit = 10, int $offset = 0): PaginatedResults;

    /**
     * Create a new resource
     *
     * @see isCreatable
     *
     * @param array $data
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws UnsupportedOperationException If Redmine's API does not support creating this kind of resource.
     * @throws JsonException
     * @throws Throwable
     */
    public static function create(array $data, $connection = null);

    /**
     * Save this resource.
     *
     * If the resource does not exist (does not have an id),
     * then this method will create it. Otherwise, the existing
     * resource will be updated.
     *
     * @see isCreatable
     * @see isUpdatable
     *
     * @param bool $reload [optional] Resource is force reloaded from
     *                     Redmine's API. This is applied ONLY when
     *                     existing resource is updated. See {@see update()}
     *                     method for details.
     *
     * @return bool
     *
     * @throws UnsupportedOperationException If Redmine's API does not support creating or updating this
     *                                       kind of resource.
     * @throws RedmineException
     * @throws JsonException
     */
    public function save(bool $reload = false): bool;

    /**
     * Update this resource
     *
     * **Caution**: resource's properties are NOT updated automatically from Redmine,
     * when update request is successfully (Redmine only returns http status 200 Ok).
     * Set the `$reload` argument to `true`, to ensure that all properties are updated
     * from source, e.g. to ensure "updated on" date is updated...etc. Or you can
     * manually invoke the {@see reload()} method.
     *
     * @see isUpdatable
     *
     * @param array $data [optional]
     * @param bool $reload [optional] Resource is force reloaded from
     *                     Redmine's API.
     *
     * @return bool
     *
     * @throws UnsupportedOperationException If Redmine's API does not support updating this kind of resource.
     */
    public function update(array $data = [], bool $reload = false): bool;

    /**
     * Delete this resource
     *
     * @see isDeletable
     *
     * @return bool
     *
     * @throws UnsupportedOperationException If Redmine's API does not support deletion this kind of resource.
     */
    public function delete(): bool;

    /**
     * Reload this resource from Redmine's API
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function reload(): bool;

    /**
     * Applies a filter or conditions callback
     *
     * @param callable|null $filters [optional] Callback that applies filters on the given Request {@see Builder}.
     *                          The callback MUST return a valid {@see Builder}
     * @param Builder|null $request [optional] Defaults to a new Request Builder, if none given
     *
     * @return Builder
     *
     * @throws RedmineException If filters callback does not return a valid Request Builder
     */
    public function applyFiltersCallback(?callable $filters = null, ?Builder $request = null): Builder;

    /**
     * Returns a prepared request builder
     *
     * @see prepareNextRequest
     *
     * @return Builder
     */
    public function request(): Builder;

    /**
     * Prepares the next request.
     *
     * Method is responsible for applying general request filters,
     * response expectations...etc
     *
     * @param Client|Builder $request
     *
     * @return Builder
     */
    public function prepareNextRequest($request): Builder;

    /**
     * Returns the Http Client set in the connection
     *
     * @see getConnection()
     *
     * @return Client
     */
    public function client(): Client;

    /**
     * Alias for {@see populate}
     *
     * @param array $data [optional]
     *
     * @return self
     */
    public function fill(array $data = []);

    /**
     * Creates resource endpoint address
     *
     * Example:
     * <pre>
     * // Without parameters
     * $resource->endpoint(); // issues.json
     *
     * // With parameters
     * $resource->endpoint(123, 'relations'); // issues/123/relations.json
     * </pre>
     *
     * @param string ...$params Url parameters
     *
     * @return string
     */
    public function endpoint(...$params): string;

    /**
     * Returns name of the resource's identifier attribute
     *
     * @return string
     */
    public function keyName(): string;

    /**
     * Returns the resource's identifier
     *
     * @return string|int|null
     */
    public function id();

    /**
     * Determine if this resource exists or not
     *
     * Method assumes that a resource exists if
     * it has an id set.
     *
     * @return bool
     */
    public function exists(): bool;

    /**
     * Decodes the given response's Json payload
     *
     * @param ResponseInterface $response
     * @param string|null [$extract] Name of top-level attribute to extract from payload,
     *                              E.g. "issue". If none given, then entire response
     *                              payload is returned.
     *
     * @return array Response payload or extracted payload
     *
     * @throws JsonException
     * @throws RedmineException When unable to extract from payload, e.g. key does not exist
     */
    public function decode(ResponseInterface $response, ?string $extract = null): array;

    /**
     * Determine if this resource can be created via the API
     *
     * @see Creatable
     *
     * @return bool
     */
    public function isCreatable(): bool;

    /**
     * Determine if this resource can be updated via the API
     *
     * @see Updatable
     *
     * @return bool
     */
    public function isUpdatable(): bool;

    /**
     * Determine if this resource can be deleted via the API
     *
     * @see Deletable
     *
     * @return bool
     */
    public function isDeletable(): bool;

    /**
     * Set the general failed expectation handler.
     *
     * Handler is used by the {@see prepareNextRequest()} method.
     *
     * @param  callable  $handler
     *
     * @return callable Previous set expectation handler
     */
    public function useFailedExpectationHandler(callable $handler): callable;

    /**
     * Returns the general failed expectation handler
     *
     * Handler is used by the {@see prepareNextRequest()} method.
     *
     * @return callable
     */
    public function failedExpectationHandler(): callable;
}
