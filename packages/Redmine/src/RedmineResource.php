<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Contracts\Redmine\Connection as ConnectionInterface;
use Aedart\Contracts\Redmine\ConnectionAware;
use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Contracts\Redmine\Resource;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Dto\ArrayDto;
use Aedart\Redmine\Connections\Connection;
use Aedart\Redmine\Exceptions\Conflict;
use Aedart\Redmine\Exceptions\NotFound;
use Aedart\Redmine\Exceptions\RedmineException;
use Aedart\Redmine\Exceptions\UnexpectedResponse;
use Aedart\Redmine\Exceptions\UnprocessableEntity;
use Aedart\Redmine\Exceptions\UnsupportedOperation;
use Aedart\Redmine\Pagination\PaginatedResults;
use Aedart\Redmine\Traits\ConnectionTrait;
use Aedart\Utils\Json;
use Aedart\Utils\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\All as StatusCodes;
use Throwable;

/**
 * Redmine Resource
 *
 * Base abstraction for a Redmine Resource (an API endpoint).
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
abstract class RedmineResource extends ArrayDto implements
    Resource
{
    use ConnectionTrait;
    use ForwardsCalls;

    /**
     * Name of the resource's identifier attribute
     *
     * @var string
     */
    protected string $identifierKey = 'id';

    /**
     * When enabled, general response expectations
     * are automatically added to the Http Client
     *
     * @see https://aedart.github.io/athenaeum/archive/current/http/clients/methods/expectations.html
     *
     * @var bool
     */
    protected bool $enableExpectations = true;

    /**
     * When set to true, then {@see Builder::debug()} added
     * to all requests
     *
     * @var bool
     */
    public static bool $debug = false;

    /**
     * List of expected Http Status Codes
     *
     * Applied only when {@see $enableExpectations} is enabled
     *
     * @var int[]
     */
    protected array $expectedStatusCodes = [
        StatusCodes::OK,
        StatusCodes::CREATED
    ];

    /**
     * General failed expectation handler
     *
     * Applied only when {@see $enableExpectations} is enabled
     *
     * @var callable
     */
    protected $failedExpectationHandler;

    /**
     * Redmine Resource
     *
     * @param array $data [optional]
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @throws Throwable
     */
    public function __construct(array $data = [], $connection = null)
    {
        $this->setConnection(
            Connection::resolve($connection)
        );

        parent::__construct($data);
    }

    /**
     * @inheritdoc
     */
    public static function make(array $data = [], $connection = null)
    {
        return new static($data, $connection);
    }

    /**
     * @inheritdoc
     */
    public function resourceNameSingular(): string
    {
        return Str::singular($this->resourceName());
    }

    /**
     * @inheritdoc
     */
    public static function list(
        int $limit = 10,
        int $offset = 0,
        array $include = [],
        $connection = null
    ): PaginatedResultsInterface {
        return static::fetchMultiple(function (Builder $request) use ($include) {
            return $request
                ->when(!empty($include), function (Builder $request) use ($include) {
                    $request->include($include);
                });
        }, $limit, $offset, $connection);
    }

    /**
     * @inheritdoc
     */
    public static function find($id, array $include = [], $connection = null)
    {
        try {
            return static::findOrFail($id, $include, $connection);
        } catch (NotFound $e) {
            // We can safely ignore this here and just return null
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findOrFail($id, array $include = [], $connection = null)
    {
        return static::fetch($id, function (Builder $request) use ($include) {
            return $request
                ->when(!empty($include), function (Builder $request) use ($include) {
                    $request->include($include);
                });
        }, $connection);
    }

    /**
     * @inheritdoc
     */
    public static function fetch($id, ?callable $filters = null, $connection = null)
    {
        $resource = static::make([], $connection);

        $response = $resource
            ->applyFiltersCallback($filters)
            ->get($resource->endpoint($id));

        return $resource->fill(
            $resource->decodeSingle($response)
        );
    }

    /**
     * @inheritdoc
     */
    public static function fetchMultiple(
        ?callable $filters = null,
        int $limit = 10,
        int $offset = 0,
        $connection = null
    ): PaginatedResultsInterface {
        $resource = static::make([], $connection);

        return $resource->paginate(
            $resource->applyFiltersCallback($filters),
            $limit,
            $offset
        );
    }

    /**
     * @inheritdoc
     */
    public function paginate(Builder $request, int $limit = 10, int $offset = 0): PaginatedResultsInterface
    {
        // Abort if API does not support listing of this kind of resource
        if (!$this->isListable()) {
            throw new UnsupportedOperation(sprintf('API does not support listing multiple %s resources', $this->resourceNameSingular()));
        }

        return PaginatedResults::fromResponse(
            $request
                ->limit($limit)
                ->offset($offset)
                ->get($this->endpoint()),
            $this
        );
    }

    /**
     * @inheritdoc
     */
    public static function create(array $data, $connection = null)
    {
        $resource = static::make($data, $connection);

        $resource->save();

        return $resource;
    }

    /**
     * @inheritdoc
     */
    public function save(bool $reload = false): bool
    {
        if (!$this->exists()) {
            return $this->performCreate();
        }

        $wasUpdated = $this->performUpdate();

        // If requested reloaded, then force reload this
        // resource.
        if ($wasUpdated && $reload) {
            return $this->reload();
        }

        return $wasUpdated;
    }

    /**
     * @inheritdoc
     */
    public function update(array $data = [], bool $reload = false): bool
    {
        // Abort if resource does not yet exist
        if (!$this->exists()) {
            return false;
        }

        return $this->fill($data)->save($reload);
    }

    /**
     * @inheritdoc
     */
    public function delete(): bool
    {
        // Abort if resource does not support delete operations
        if (!$this->isDeletable()) {
            throw new UnsupportedOperation(sprintf('API does not support delete operation for %s resources', $this->resourceNameSingular()));
        }

        // Abort if resource does not have an id - meaning that we are
        // unable to perform a delete request
        if (!$this->exists()) {
            return false;
        }

        $this
            ->request()
            ->delete($this->endpoint(
                $this->id()
            ));

        return true;
    }

    /**
     * @inheritdoc
     */
    public function reload(): bool
    {
        if (!$this->exists()) {
            return false;
        }

        $response = $this
            ->request()
            ->get($this->endpoint($this->id()));

        $this->fill(
            $this->decodeSingle($response)
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function applyFiltersCallback(?callable $filters = null, ?Builder $request = null): Builder
    {
        // Resolve the request builder
        $request = $request ?? $this->request();

        // Apply the filters and conditions callback, if any given
        if (is_callable($filters)) {
            $modified = $filters($request);
        } else {
            $modified = $request;
        }

        // Assert that a request builder was returned
        if (!isset($modified) || !($modified instanceof Builder)) {
            throw new RedmineException('Conditions callback MUST return a valid Request Builder instance');
        }

        // Finally, return the modified builder
        return $modified;
    }

    /**
     * @inheritdoc
     */
    public function request(): Builder
    {
        return $this->prepareNextRequest(
            $this->client()
        );
    }

    /**
     * @inheritdoc
     */
    public function prepareNextRequest($request): Builder
    {
        // Add general response expectations, if required
        if ($this->enableExpectations) {
            $request = $request
                ->expect($this->expectedStatusCodes, $this->failedExpectationHandler());
        }

        // Debug, when required
        if (static::$debug) {
            $request = $request->debug();
        }

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function client(): Client
    {
        return $this->getConnection()->client();
    }

    /**
     * @inheritdoc
     */
    public function populate(array $data = []): void
    {
        parent::populate($data);

        // Resolve connection for evt. nested Resources / DTOs that
        // require such...
        foreach ($this->properties as $property) {
            if ($property instanceof ConnectionAware) {
                $property->setConnection($this->getConnection());
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function fill(array $data = [])
    {
        $this->populate($data);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function endpoint(...$params): string
    {
        $parts = '';
        if (!empty($params)) {
            $parts = '/' . implode('/', $params);
        }

        return $this->resourceName() . $parts . '.json';
    }

    /**
     * @inheritdoc
     */
    public function keyName(): string
    {
        return $this->identifierKey;
    }

    /**
     * @inheritdoc
     */
    public function id()
    {
        $key = $this->keyName();

        return $this->{$key};
    }

    /**
     * @inheritdoc
     */
    public function exists(): bool
    {
        $key = $this->keyName();

        return isset($this->{$key});
    }

    /**
     * @inheritdoc
     */
    public function decode(ResponseInterface $response, ?string $extract = null): array
    {
        // Get response body - abort if it's empty
        $content = $response->getBody()->getContents();
        if (empty($content)) {
            return [];
        }

        // Decode response, but abort if payload is empty
        $payload = Json::decode($content, true);
        if (empty($payload)) {
            return [];
        }

        // When nothing requested extracted from the payload, just return
        // the entire decoded content.
        if (!isset($extract)) {
            return $payload;
        }

        // Otherwise, extract whatever key has been requested...
        return $this->extractFromPayload($extract, $payload);
    }

    /**
     * Decode a single resource from given response
     *
     * @param ResponseInterface $response
     *
     * @return array Response payload
     *
     * @throws JsonException
     */
    public function decodeSingle(ResponseInterface $response): array
    {
        return $this->decode($response, $this->resourceNameSingular());
    }

    /**
     * Decode multiple resource from given response
     *
     * @param ResponseInterface $response
     *
     * @return array Response payload, containing multiple resources
     *
     * @throws JsonException
     */
    public function decodeMultiple(ResponseInterface $response): array
    {
        return $this->decode($response, $this->resourceName());
    }

    /**
     * Extract a key's value from given payload
     *
     * @param string $key
     * @param array $payload Decoded response payload
     *
     * @return mixed
     *
     * @throws RedmineException When unable to extract from payload, e.g. key does not exist
     */
    public function extractFromPayload(string $key, array $payload)
    {
        if (!isset($payload[$key])) {
            throw new RedmineException(sprintf('Unable to extract "%s" from response payload. Attribute does not exist', $key));
        }

        return $payload[$key];
    }

    /**
     * @inheritdoc
     */
    public function isListable(): bool
    {
        return $this instanceof Listable;
    }

    /**
     * @inheritdoc
     */
    public function isCreatable(): bool
    {
        return $this instanceof Creatable;
    }

    /**
     * @inheritdoc
     */
    public function isUpdatable(): bool
    {
        return $this instanceof Updatable;
    }

    /**
     * @inheritdoc
     */
    public function isDeletable(): bool
    {
        return $this instanceof Deletable;
    }

    /**
     * @inheritdoc
     */
    public function useFailedExpectationHandler(callable $handler): callable
    {
        $previous = $this->failedExpectationHandler();

        $this->failedExpectationHandler = $handler;

        return $previous;
    }

    /**
     * @inheritdoc
     */
    public function failedExpectationHandler(): callable
    {
        // Set a default failed expectation handler when none given...
        if (!isset($this->failedExpectationHandler)) {
            $this->failedExpectationHandler = function () {
                $this->defaultFailedExpectationHandler(...func_get_args());
            };
        }

        return $this->failedExpectationHandler;
    }

    /**
     * Forward calls to the Http Client's request builder
     *
     * @param string $name method name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function __call(string $name, $arguments)
    {
        return $this->forwardCallTo($this->request(), $name, $arguments);
    }

    /**
     * Forward static calls to the Http Client's request builder
     *
     * @param string $name method name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, $arguments)
    {
        return static::make()->$name(...$arguments);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Performs a create new resource request
     *
     * @return bool
     *
     * @throws UnprocessableEntity
     * @throws UnexpectedResponse
     * @throws JsonException
     */
    protected function performCreate(): bool
    {
        // Abort if resource does not support create operations
        if (!$this->isCreatable()) {
            throw new UnsupportedOperation(sprintf('API does not support create operation for %s resources', $this->resourceNameSingular()));
        }

        $payload = [
            $this->resourceNameSingular() => $this->toArray()
        ];

        $response = $this
            ->request()
            ->post($this->endpoint(), $payload);

        // Extract and (re)populate resource
        $this->fill(
            $this->decodeSingle($response)
        );

        return true;
    }

    /**
     * Performs update existing resource request
     *
     * @return bool
     *
     * @throws UnprocessableEntity
     * @throws NotFound
     * @throws UnexpectedResponse
     * @throws JsonException
     */
    protected function performUpdate(): bool
    {
        // Abort if resource does not support update operations
        if (!$this->isUpdatable()) {
            throw new UnsupportedOperation(sprintf('API does not support update operation for %s resources', $this->resourceNameSingular()));
        }

        $id = $this->id();
        $payload = [
            $this->resourceNameSingular() => $this->toArray()
        ];

        $response = $this
            ->request()
            ->put($this->endpoint($id), $payload);

        // Extract and (re)populate resource (if possible)
        // Note: Unlike the "create" method, Redmine does NOT
        // appear to send back a full resource when it has been
        // successfully updated.
        $this->fill(
            $this->decodeSingle($response)
        );

        return true;
    }

    /**
     * The default "general" failed expectation handler
     *
     * @param  Status  $status
     * @param  ResponseInterface  $response
     * @param  RequestInterface  $request
     *
     * @throws ErrorResponseException
     */
    protected function defaultFailedExpectationHandler(Status $status, ResponseInterface $response, RequestInterface $request)
    {
        $code = $status->code();

        if ($code === StatusCodes::NOT_FOUND) {
            throw NotFound::from($response, $request, sprintf('%s was not found', (string) $request->getUri()));
        }

        if ($code === StatusCodes::UNPROCESSABLE_ENTITY) {
            throw UnprocessableEntity::from($response, $request);
        }

        if ($code === StatusCodes::CONFLICT) {
            throw Conflict::from($response, $request);
        }

        // Otherwise,
        throw UnexpectedResponse::from($response, $request);
    }
}
