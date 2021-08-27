<?php

namespace Aedart\Tests\TestCases\Redmine;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Redmine\Connection as ConnectionInterface;
use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Redmine\Connections\Connection;
use Aedart\Redmine\Providers\RedmineServiceProvider;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Utils\Json;
use Codeception\Configuration;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\All as StatusCodes;

/**
 * Redmine Test Case
 *
 * Base test case for the Redmine package components
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Redmine
 */
abstract class RedmineTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;

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
     * @throws \JsonException
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
     * @throws ConnectionException
     * @throws \JsonException
     */
    public function mockResponseConnection(
        array $body = [],
        int $status = StatusCodes::OK,
        array $headers = [],
        ?string $profile = null
    ): ConnectionInterface {
        $response = $this->mockJsonResponse($body, $status, $headers);

        return Connection::resolve($profile)->mock($response);
    }

    /**
     * Makes a new Dummy Resource instance
     *
     * @param array $data [optional]
     * @param string|ConnectionInterface|null $connection [optional] Redmine connection profile
     *
     * @return DummyResource
     *
     * @throws \Throwable
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
}
