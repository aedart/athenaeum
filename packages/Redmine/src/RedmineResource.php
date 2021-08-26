<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Contracts\Redmine\Connection as ConnectionInterface;
use Aedart\Contracts\Redmine\ConnectionAware;
use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Dto\ArrayDto;
use Aedart\Redmine\Connections\Connection;
use Aedart\Redmine\Exceptions\Conflict;
use Aedart\Redmine\Exceptions\NotFound;
use Aedart\Redmine\Exceptions\RedmineException;
use Aedart\Redmine\Exceptions\UnexpectedResponse;
use Aedart\Redmine\Exceptions\UnprocessableEntity;
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
    ConnectionAware
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
     * Creates a new resource instance
     *
     * @param array $data [optional]
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws Throwable
     */
    public static function make(array $data = [], $connection = null)
    {
        return new static($data, $connection);
    }

    /**
     * Returns Redmine resource name in plural form
     * E.g. issues, projects, relations, etc.
     *
     * @see https://www.redmine.org/projects/redmine/wiki/rest_api
     *
     * @return string
     */
    abstract public function resourceName(): string;

    /**
     * Returns Redmine resource name in singular form
     * E.g. issue, project, relation, etc.
     *
     * @see resourceName
     *
     * @return string
     */
    public function resourceNameSingular(): string
    {
        return Str::singular($this->resourceName());
    }

    /**
     * Fetch list of resources
     *
     * @param int $limit [optional]
     * @param int $offset [optional]
     * @param string[] $include [optional] List of associated data to include
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return PaginatedResultsInterface<static>|static[]
     *
     * @throws JsonException
     * @throws Throwable
     */
    public static function list(
        int $limit = 10,
        int $offset = 0,
        array $include = [],
        $connection = null
    ): PaginatedResultsInterface {
        $resource = static::make([], $connection);

        $request = $resource
            ->request()

            // Include related data
            ->when(!empty($include), function (Builder $request) use ($include) {
                $request->include($include);
            });

        return $resource->paginate($request, $limit, $offset);
    }

    /**
     * Finds resource that matches given id
     *
     * @param string|int $id Redmine resource id
     * @param string[] $include [optional] List of associated data to include
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return static|null
     *
     * @throws UnexpectedResponse
     * @throws JsonException
     * @throws Throwable
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
     * Finds resource that matches given id or fails
     *
     * @param string|int $id Redmine resource id
     * @param string[] $include [optional] List of associated data to include
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws NotFound
     * @throws UnexpectedResponse
     * @throws JsonException
     * @throws Throwable
     */
    public static function findOrFail($id, array $include = [], $connection = null)
    {
        $resource = static::make([], $connection);

        $response = $resource
            ->request()

            // Include related data
            ->when(!empty($include), function (Builder $request) use ($include) {
                $request->include($include);
            })

            // Fetch the resource
            ->get($resource->endpoint($id));

        // Extract and populate resource
        return $resource->fill(
            $resource->decodeSingle($response)
        );
    }

    /**
     * Paginate the given request
     *
     * @param  Builder  $request
     * @param int $limit [optional]
     * @param int $offset [optional]
     *
     * @return PaginatedResultsInterface<static>|static[]
     *
     * @throws JsonException
     * @throws Throwable
     */
    public function paginate(Builder $request, int $limit = 10, int $offset = 0): PaginatedResultsInterface
    {
        return PaginatedResults::fromResponse(
            $request
                ->limit($limit)
                ->offset($offset)
                ->get($this->endpoint()),
            $this
        );
    }

    /**
     * Create a new resource
     *
     * @param array $data
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws JsonException
     * @throws Throwable
     */
    public static function create(array $data, $connection = null)
    {
        $resource = static::make($data, $connection);

        $resource->save();

        return $resource;
    }

    /**
     * Save this resource.
     *
     * If the resource does not exist (does not have an id),
     * then this method will create it. Otherwise, the existing
     * resource will be updated.
     *
     * @return bool
     *
     * @throws RedmineException
     * @throws JsonException
     */
    public function save(): bool
    {
        if ($this->exists()) {
            return $this->performCreate();
        }

        return $this->performUpdate();
    }

    /**
     * Update this resource
     *
     * @param array $data [optional]
     *
     * @return bool
     */
    public function update(array $data = []): bool
    {
        // Abort if resource does not yet exist
        if (!$this->exists()) {
            return false;
        }

        return $this->fill($data)->save();
    }

    /**
     * Delete this resource
     *
     * @return bool
     */
    public function delete(): bool
    {
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
     * Returns a prepared request builder
     *
     * @return Builder
     */
    public function request(): Builder
    {
        return $this->prepareNextRequest(
            $this->client()
        );
    }

    /**
     * Returns the Http Client set in the connection
     *
     * @see getConnection()
     *
     * @return Client
     */
    public function client(): Client
    {
        return $this->getConnection()->client();
    }

    /**
     * Alias for {@see populate}
     *
     * @param array $data [optional]
     *
     * @return self
     */
    public function fill(array $data = []): self
    {
        $this->populate($data);

        return $this;
    }

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
    public function endpoint(...$params): string
    {
        $parts = '';
        if (!empty($params)) {
            $parts = '/' . implode('/', $params);
        }

        return $this->resourceName() . $parts . '.json';
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
    public function decode(ResponseInterface $response, ?string $extract = null): array
    {
        $payload = Json::decode($response->getBody()->getContents(), true);

        if (!isset($extract)) {
            return $payload;
        }

        return $this->extractFromPayload($extract, $payload);
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
     * Returns name of the resource's identifier attribute
     *
     * @return string
     */
    public function keyName(): string
    {
        return $this->identifierKey;
    }

    /**
     * Returns the resource's identifier
     *
     * @return string|int|null
     */
    public function id()
    {
        $key = $this->keyName();

        return $this->{$key};
    }

    /**
     * Determine if this resource exists or not
     *
     * Method assumes that a resource exists if
     * it has an id set.
     *
     * @return bool
     */
    public function exists(): bool
    {
        $key = $this->keyName();

        return isset($this->{$key});
    }

    /**
     * Prepares the next request
     *
     * @param Client|Builder $request
     *
     * @return Builder
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
     * Set the general failed expectation handler
     *
     * @param  callable  $handler
     *
     * @return self
     */
    public function useFailedExpectationHandler(callable $handler): self
    {
        $this->failedExpectationHandler = $handler;

        return $this;
    }

    /**
     * Returns the general failed expectation handler
     *
     * @return callable
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
     * Forward calls to the Http Client
     *
     * @param string $name method name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function __call(string $name, $arguments)
    {
        return $this->forwardCallTo($this->client(), $name, $arguments);
    }

    /**
     * Forward static calls to the Http Client
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
        $payload = $this->toArray();

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
        $id = $this->id();
        $payload = $this->toArray();

        $response = $this
            ->request()
            ->put($this->endpoint($id), $payload);

        // Extract and (re)populate resource
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
