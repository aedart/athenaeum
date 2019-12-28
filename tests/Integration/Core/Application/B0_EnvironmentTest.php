<?php


namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Contracts\Core\Application;
use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Exceptions\UnableToDetectOrLoadEnv;
use Aedart\Testing\TestCases\ApplicationIntegrationTestCase;
use Codeception\Configuration;
use Illuminate\Support\Env;

/**
 * A1_RunTest
 *
 * @group application
 * @group application-b0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class B0_EnvironmentTest extends ApplicationIntegrationTestCase
{
    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        Env::disablePutenv();
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        Env::enablePutenv();

        parent::_after();
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function createApplication(): Application
    {
        $app = parent::createApplication();

        // Set the environment path
        $app->getPathsContainer()->setEnvironmentPath( Configuration::dataDir() . 'environment' );

        return $app;
    }

    /**
     * Bootstrap the application
     */
    protected function bootstrap()
    {
        $this->app->bootstrapWith([
            DetectAndLoadEnvironment::class
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function failsWhenNoEnvironmentFileFound()
    {
        $this->expectException(UnableToDetectOrLoadEnv::class);

        // Set environment path to a none-existing dir.
        $app = $this->app;
        $app->getPathsContainer()->setEnvironmentPath( Configuration::dataDir() . 'none-existing-directory' );

        $this->bootstrap();
    }

    /**
     * @test
     */
    public function defaultsToEnvironmentFromEnvFile()
    {
        $app = $this->app;

        // Unset "testing" environment
        unset($app['env']);

        $this->bootstrap();

        $this->assertSame('development', $app->environment());
    }

    /**
     * @test
     */
    public function canDetectEnvironmentFromEnvVariable()
    {
        $app = $this->app;

        // Unset "testing" environment
        unset($app['env']);

        // Set environment directly... Simulates that a web-server has specified this.
        $_SERVER['APP_ENV'] = 'playing';

        $this->bootstrap();

        $this->assertSame('playing', $app->environment());
    }

    /**
     * @test
     */
    public function canDetectEnvironmentFromConsole()
    {
        $app = $this->app;

        // Unset "testing" environment
        unset($app['env']);

        // Set environment name via $_SERVER['argv'], which should be read by
        // Symfony's ArgvInput component
        $_SERVER['argv'][] = '--env=console';

        $this->bootstrap();

        $this->assertSame('my-cgi-env', $app->environment());
    }
}
