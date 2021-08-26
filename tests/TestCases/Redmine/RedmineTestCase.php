<?php

namespace Aedart\Tests\TestCases\Redmine;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
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
        $name = (new DummyResource())->resourceName();

        $list = [];
        while ($amount--) {
            $list[] = $this->makeDummyPayload();
        }

        return [
            $name => $list
        ];
    }
}
