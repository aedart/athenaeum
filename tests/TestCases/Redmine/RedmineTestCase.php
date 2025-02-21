<?php

namespace Aedart\Tests\TestCases\Redmine;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Contracts\Redmine\Connection as ConnectionInterface;
use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Redmine\Connections\Connection;
use Aedart\Redmine\Group;
use Aedart\Redmine\Issue;
use Aedart\Redmine\Project;
use Aedart\Redmine\ProjectMembership;
use Aedart\Redmine\Providers\RedmineServiceProvider;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Redmine\Role;
use Aedart\Redmine\User;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Utils\Json;
use Codeception\Configuration;
use Codeception\Exception\ConfigurationException;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\Http;
use JsonException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\All as StatusCodes;
use Throwable;

/**
 * Redmine Test Case
 *
 * Base test case for the Redmine package components
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Redmine
 */
abstract class RedmineTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;
    use FileTrait;

    /**
     * WARNING: When true, then some tests will perform actual
     * requests to a Redmine API instance.
     *
     * If so, ensure that REDMINE_API_URI and REDMINE_TOKEN
     * environment variables are set inside .testing file
     *
     * @var bool
     */
    protected bool $live = false;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->directory())
            ->load();

        // Create directories
        $fs = $this->getFile();

        if (!$fs->exists($this->downloadDir())) {
            $fs->makeDirectory($this->downloadDir());
        }

        // Empty directories - if needed
        $fs->deleteDirectory($this->downloadDir(), true);

        // Read the "live" test state from the environment file
        $this->live = env('REDMINE_LIVE_TEST', false);
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        parent::_after();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            HttpClientServiceProvider::class,
            RedmineServiceProvider::class
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        // Ensure .env is loaded
        $app->useEnvironmentPath(__DIR__ . '/../../../');
        $app->loadEnvironmentFrom('.testing');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
    }

    /**
     * Determine if "real" (live) API requests should
     * be undertaken!
     *
     * @return bool
     */
    protected function isLive(): bool
    {
        return $this->live;
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function directory(): string
    {
        return Configuration::dataDir() . 'configs/redmine';
    }

    /**
     * Returns path to a dummy file (for upload tests)
     *
     * @return string
     */
    public function dummyFile(): string
    {
        return Configuration::dataDir() . '/redmine/test.txt';
    }

    /**
     * Returns the download directory path
     *
     * @return string
     *
     * @throws ConfigurationException
     */
    public function downloadDir(): string
    {
        return Configuration::outputDir() . '/redmine/';
    }

    /**
     * Mock a json response
     *
     * Mock will automatically have it's content-type header set
     * to application/json
     *
     * @param array $body [optional] Body to be json encoded
     * @param int $status [optional] Http Status code
     * @param array $headers [optional] Evt. headers
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function mockJsonResponse(array $body = [], int $status = StatusCodes::OK, array $headers = []): ResponseInterface
    {
        $encoded = Json::encode($body);

        $headers = array_merge([
            'Content-Type' => 'application/json'
        ], $headers);

        return Http::response($encoded, $status, $headers)->wait();
    }

    /**
     * Mock a "list of resources" response from Redmine
     *
     * @param array $list List of resource (NOTE: each entry must be formatted accordingly)
     * @param string $resourceClass
     * @param int $total [optional]
     * @param int $limit [optional]
     * @param int $offset [optional]
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function mockListOfResourcesResponse(
        array $list,
        string $resourceClass,
        int $total = 50,
        int $limit = 10,
        int $offset = 0
    ): ResponseInterface {
        /** @var RedmineApiResource $resource */
        $resource = $resourceClass::make();

        $data = [
            $resource->resourceName() => $list,
        ];

        $data['total_count'] = $total;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        return $this->mockJsonResponse($data);
    }

    /**
     * Mock a "created" response from Redmine
     *
     * @param array $data
     * @param string|int $id
     * @param string $resourceClass Class path to resource
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function mockCreatedResourceResponse(array $data, $id, string $resourceClass): ResponseInterface
    {
        /** @var RedmineApiResource $resource */
        $resource = $resourceClass::make();

        // Pretend that data was created, but adding an id
        $data = array_merge($data, [
            $resource->keyName() => $id,
        ]);

        return $this->mockJsonResponse([
            $resource->resourceNameSingular() => $data
        ], StatusCodes::CREATED);
    }

    /**
     * Mock a "reloaded" response from Redmine
     *
     * @param array $data
     * @param string|int $id
     * @param string $resourceClass Class path to resource
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function mockReloadedResourceResponse(array $data, $id, string $resourceClass): ResponseInterface
    {
        return $this->mockSingleResourceResponse($data, $id, $resourceClass);
    }

    /**
     * Mock a "not found" response
     *
     * @return ResponseInterface
     *
     * @throws JsonException
     */
    public function mockNotFoundResponse(): ResponseInterface
    {
        return $this->mockJsonResponse([], StatusCodes::NOT_FOUND);
    }

    /**
     * Mock a successful single response from Redmine
     *
     * @param array $data
     * @param string|int $id
     * @param string $resourceClass Class path to resource
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function mockSingleResourceResponse(array $data, $id, string $resourceClass): ResponseInterface
    {
        /** @var RedmineApiResource $resource */
        $resource = $resourceClass::make();

        // Pretend that data was created, but adding an id
        $data = array_merge($data, [
            $resource->keyName() => $id,
        ]);

        return $this->mockJsonResponse([
            $resource->resourceNameSingular() => $data
        ]);
    }

    /**
     * Mock a "file download" response
     *
     * @param string $sourceFile
     * @param string $contentType
     *
     * @return ResponseInterface
     */
    public function mockDownloadFileResponse(string $sourceFile, string $contentType): ResponseInterface
    {
        $content = file_get_contents($sourceFile);
        $headers = [
            'Content-Type' => $contentType
        ];

        return Http::response($content, StatusCodes::OK, $headers)->wait();
    }

    /**
     * Mock a successful "updated" response
     *
     * @return ResponseInterface
     *
     * @throws JsonException
     */
    public function mockUpdatedResourceResponse(): ResponseInterface
    {
        return $this->mockJsonResponse([], StatusCodes::OK);
    }

    /**
     * Mock a successful "deleted" response
     *
     * @return ResponseInterface
     *
     * @throws JsonException
     */
    public function mockDeletedResourceResponse(): ResponseInterface
    {
        return $this->mockJsonResponse([], StatusCodes::OK);
    }

    /**
     * Mock a successful "file uploaded" response
     *
     * @param int|null $id [optional]
     * @param string|null $token [optional]
     *
     * @return ResponseInterface
     *
     * @throws JsonException
     */
    public function mockUploadedResponse(?int $id = null, ?string $token = null): ResponseInterface
    {
        $faker = $this->getFaker();

        $id = $id ?? $faker->randomNumber(4, true);
        $token = $token ?? $faker->sha256();

        return $this->mockJsonResponse([
            'upload' => [
                'id' => $id,
                'token' => $token
            ]
        ], StatusCodes::CREATED);
    }

    /**
     * Mock the next response for a Redmine Resource
     *
     * Method applies a mocked response handling onto the resource
     * connection, which then MUST be passed on to the actual Redmine
     * Resource.
     *
     * @param array $body [optional] Body to be json encoded
     * @param int $status [optional] Http Status code
     * @param array $headers [optional] Evt. headers
     * @param string|null $profile [optional] Connection profile name
     *
     * @return ConnectionInterface
     *
     * @throws ConnectionException
     * @throws JsonException
     */
    public function connectionWithMock(
        array $body = [],
        int $status = StatusCodes::OK,
        array $headers = [],
        ?string $profile = null
    ): ConnectionInterface {
        $response = $this->mockJsonResponse($body, $status, $headers);

        return Connection::resolve($profile)->mock($response);
    }

    /**
     * Mock the next responses for a Redmine Resource
     *
     * @param ResponseInterface[] $responses
     * @param string|null $profile [optional] Connection profile name
     *
     * @return ConnectionInterface
     *
     * @throws ConnectionException
     */
    public function connectWithMultipleMocks(array $responses, ?string $profile = null): ConnectionInterface
    {
        return Connection::resolve($profile)->mock($responses);
    }

    /**
     * Returns a "live" or mocked connection to the Redmine Api
     *
     * @see isLive()
     *
     * @param ResponseInterface[] $responses
     * @param string|null $profile [optional] Connection profile name
     *
     * @return ConnectionInterface
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    public function liveOrMockedConnection(array $responses, string|null $profile = null): ConnectionInterface
    {
        if (!$this->isLive()) {
            return Connection::resolve($profile)->mock($responses);
        }

        // When using a live connection, it is important that the response can be debugged.
        // To do so, we specify a custom "failed expectation handler", ...
        return Connection::resolve($profile)
            ->useFailedExpectationHandler(function(Status $status, ResponseInterface $response, RequestInterface $request) {
                // Output response, when running in debug mode
                ConsoleDebugger::output([
                    'request' => (string) $request->getUri(),
                    'response' => [
                        'status' => $status->code() . ' ' . $status->phrase(),
                        'headers' => $response->getHeaders(),
                        'body' => $response->getBody()->getContents()
                    ]
                ]);

                // Ensure to rewind content for response.
                $response->getBody()->rewind();

                // Forward to evt. default specified expectation handler
                $defaultHandler = Project::make()->failedExpectationHandler();
                $defaultHandler($status, $response, $request);
            });
    }

    /**
     * Makes a new Dummy Resource instance
     *
     * @param array $data [optional]
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return DummyResource
     *
     * @throws Throwable
     */
    public function makeDummyResource(array $data = [], $connection = null): DummyResource
    {
        return DummyResource::make($data, $connection);
    }

    /**
     * Makes a new dummy resource payload
     *
     * @param array $data [optional]
     *
     * @return array
     */
    public function makeDummyPayload(array $data = []): array
    {
        $faker = $this->getFaker();

        return array_merge([
            'id' => $faker->unique()->randomNumber(4, true),
            'name' => $faker->name
        ], $data);
    }

    /**
     * Returns a list of dummies...
     *
     * @param int $amount [optional]
     *
     * @return array
     */
    public function makeDummyList(int $amount = 3): array
    {
        $name = $this->makeDummyResource()->resourceName();

        $list = [];
        while ($amount--) {
            $list[] = $this->makeDummyPayload();
        }

        return [
            $name => $list
        ];
    }

    /**
     * Makes a new dummy response payload
     *
     * @param array $data [optional]
     *
     * @return array
     *
     * @throws Throwable
     */
    public function makeSingleDummyResponsePayload(array $data = []): array
    {
        $name = $this->makeDummyResource()->resourceNameSingular();

        return [
            $name => $this->makeDummyPayload($data)
        ];
    }

    /**
     * Returns a "paginated" results payload from redmine
     *
     * @param int $amount [optional] Amount of dummies to generate for response
     * @param int $total [optional] Total results to state available in response
     * @param int $limit [optional] Limit to state in response
     * @param int $offset [optional] Offset to state in response
     *
     * @return array
     */
    public function makePaginatedDummyPayload(
        int $amount = 3,
        int $total = 50,
        int $limit = 10,
        int $offset = 0
    ): array {
        $payload = $this->makeDummyList($amount);

        $payload['total_count'] = $total;
        $payload['limit'] = $limit;
        $payload['offset'] = $offset;

        return $payload;
    }

    /**
     * Creates a placeholder project resource for issues
     *
     * NOTE: The project is expected to be deleted upton test
     * completion - THIS MUST BE DONE MANUALLY!
     *
     * @return Project
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function createProject(): Project
    {
        $data = [
            'name' => 'Test project via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Project::class),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //

        return Project::create($data, [], $connection);
    }

    /**
     * Create a new user member for given project
     *
     * @param Project $project
     * @param User $user
     * @param Role[] $roles
     *
     * @return ProjectMembership
     *
     * @throws JsonException
     * @throws Throwable
     * @throws UnsupportedOperationException
     */
    public function createProjectUserMember(Project $project, User $user, array $roles): ProjectMembership
    {
        $data = [
            'project' => [ 'id' => $project->id, 'name' => $project->name ],
            'user' => [ 'id' => $user->id() ],
            'roles' => []
        ];

        foreach ($roles as $role) {
            $data['roles'][] = [
                'id' => $role->id(),
                'name' => $role->name
            ];
        }

        // (Re)Mock connection on project, to return new membership response.
        // Connection is passed on to related resource...
        $originalConnection = $project->getConnection();

        $project->setConnection($this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, ProjectMembership::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create membership via the project's helper method!
        $member = $project->addUserMember($user, collect($roles)->pluck('id')->toArray());

        $project->setConnection($originalConnection);

        return $member;
    }

    /**
     * Create a new group member for given project
     *
     * @param Project $project
     * @param Group $group
     * @param Role[] $roles
     *
     * @return ProjectMembership
     *
     * @throws JsonException
     * @throws Throwable
     * @throws UnsupportedOperationException
     */
    public function createProjectGroupMember(Project $project, Group $group, array $roles): ProjectMembership
    {
        $data = [
            'project' => [ 'id' => $project->id, 'name' => $project->name ],
            'group' => [ 'id' => $group->id() ],
            'roles' => []
        ];

        foreach ($roles as $role) {
            $data['roles'][] = [
                'id' => $role->id(),
                'name' => $role->name
            ];
        }

        // (Re)Mock connection on project, to return new membership response.
        // Connection is passed on to related resource...
        $originalConnection = $project->getConnection();

        $project->setConnection($this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, ProjectMembership::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create membership via the project's helper method!
        $member = $project->addGroupMember($group, collect($roles)->pluck('id')->toArray());

        $project->setConnection($originalConnection);

        return $member;
    }

    /**
     * Create an issue for given project
     *
     * @param int $projectId
     * @param array $data [optional]
     *
     * @return Issue
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function createIssue(int $projectId, array $data = []): Issue
    {
        $data = array_merge([
            'project_id' => $projectId,
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Project issue - via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ], $data);

        $id = $this->getFaker()->unique()->randomNumber(4, true);

        return Issue::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, $id, Issue::class),
            $this->mockDeletedResourceResponse()
        ]));
    }

    /**
     * Creates a new group
     *
     * @param array $data [optional]
     *
     * @return Group
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function createGroup(array $data = []): Group
    {
        $data = array_merge([
            'name' => 'Test Group ' . $this->getFaker()->unique()->randomNumber(4, true) . ' @aedart/athenaeum-redmine'
        ], $data);

        return Group::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Group::class),
            $this->mockDeletedResourceResponse()
        ]));
    }

    /**
     * Returns a random role
     *
     * @return Role
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function randomRole(): Role
    {
        $list = [
            [
                'id' => 1,
                'name' => 'manager',
            ],
            [
                'id' => 2,
                'name' => 'developer',
            ],
            [
                'id' => 3,
                'name' => 'reporter',
            ],
        ];

        $roles = Role::list(10, 0, [], $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, Role::class)
        ]));

        // Select a random target
        /** @var Role $target */
        return $roles->results()->random(1)->first();
    }

    /**
     * Create a new user
     *
     * @param array $data [optional]
     *
     * @return User
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function createUser(array $data = []): User
    {
        $faker = $this->getFaker();

        $data = array_merge([
            'login' => $faker->userName,
            'password' => $faker->password(15),
            'firstname' => 'Test User',
            'lastname' => 'Athenaeum Redmine',
            'mail' => 'athenaeum-test-' . $faker->randomNumber(6, true) . '@example.org'
        ], $data);

        return User::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, User::class),
            $this->mockDeletedResourceResponse()
        ]));
    }
}
