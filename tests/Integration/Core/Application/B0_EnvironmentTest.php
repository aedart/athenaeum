<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Exceptions\UnableToDetectOrLoadEnv;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;

/**
 * A1_RunTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-b0',
)]
class B0_EnvironmentTest extends AthenaeumCoreTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function createApplication(PathsContainer|array|null $paths = null): Application
    {
        $app = parent::createApplication($paths);

        // Set the environment path
        $app->getPathsContainer()->setEnvironmentPath(Configuration::dataDir() . 'environment');

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
     * @throws \Throwable
     */
    #[Test]
    public function failsWhenNoEnvironmentFileFound()
    {
        $this->expectException(UnableToDetectOrLoadEnv::class);

        // Set environment path to a none-existing dir.
        $app = $this->app;
        $app->getPathsContainer()->setEnvironmentPath(Configuration::dataDir() . 'none-existing-directory');

        $this->bootstrap();
    }

    #[Test]
    public function defaultsToEnvironmentFromEnvFile()
    {
        $app = $this->app;

        // Unset "testing" environment
        unset($app['env']);

        $this->bootstrap();

        $this->assertSame('development', $app->environment());
    }

    #[Test]
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

    #[Test]
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

    /*****************************************************************
     * Test of utility methods
     ****************************************************************/

    #[Test]
    public function canDetermineIfRunningInTestingEnv()
    {
        $app = $this->app;

        $this->bootstrap();

        $this->assertFalse($app->isLocal(), 'should not be in local environment');
        $this->assertFalse($app->isProduction(), 'should not be in production environment');
        $this->assertTrue($app->runningUnitTests(), 'should be running in testing environment');

        $this->assertTrue($app->environment('testing'), 'environment comparison failed');
    }
}
