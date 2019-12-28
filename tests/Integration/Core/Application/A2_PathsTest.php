<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Helpers\Paths;
use Aedart\Testing\TestCases\ApplicationIntegrationTestCase;
use LogicException;

/**
 * A2_PathsTest
 *
 * @group application
 * @group application-a2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class A2_PathsTest extends ApplicationIntegrationTestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     */
    public function useDefaultPathsContainerWhenNoneGiven()
    {
        $this->app->destroy();

        $app = $this->createApplication();
        $app->setPathsContainer(null); // Reset paths that are set by "createApplication"

        $this->assertNotNull($app->getPathsContainer());
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canCreateInstanceWithCustomPathsContainer()
    {
        $this->app->destroy();

        $paths = new Paths();
        $app = $this->createApplication($paths);

        $this->assertSame($paths, $app->getPathsContainer());
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function failsWhenInvalidPathsContainerGiven()
    {
        $this->expectException(LogicException::class);

        $this->app->destroy();

        $this->createApplication('invalid-paths-arg');
    }

    /*****************************************************************
     * Paths that can be specified via Patch Container
     ****************************************************************/

    /**
     * @test
     */
    public function canReadBasePath()
    {
        $path = $this->app->basePath();

        $this->assertNotEmpty($path);
    }

    /**
     * @test
     */
    public function canReadBootstrapPath()
    {
        $path = $this->app->bootstrapPath();

        $this->assertNotEmpty($path);
    }

    /**
     * @test
     */
    public function canReadConfigPath()
    {
        $path = $this->app->configPath();

        $this->assertNotEmpty($path);
    }

    /**
     * @test
     */
    public function canReadDatabasePath()
    {
        $path = $this->app->databasePath();

        $this->assertNotEmpty($path);
    }

    /**
     * @test
     */
    public function canReadEnvironmentPath()
    {
        $path = $this->app->environmentPath();

        $this->assertNotEmpty($path);
    }

    /**
     * @test
     */
    public function canReadResourcePath()
    {
        $path = $this->app->resourcePath();

        $this->assertNotEmpty($path);
    }

    /**
     * @test
     */
    public function canReadStoragePath()
    {
        $path = $this->app->storagePath();

        $this->assertNotEmpty($path);
    }

    /*****************************************************************
     * Unsupported "cache" paths
     ****************************************************************/

    /**
     * @test
     */
    public function canReadCachedConfigPath()
    {
        $path = $this->app->getCachedConfigPath();

        $this->assertEmpty($path);
    }

    /**
     * @test
     */
    public function canReadCachedServicesPath()
    {
        $path = $this->app->getCachedServicesPath();

        $this->assertEmpty($path);
    }

    /**
     * @test
     */
    public function canReadCachedPackagesPath()
    {
        $path = $this->app->getCachedPackagesPath();

        $this->assertEmpty($path);
    }

    /**
     * @test
     */
    public function canReadCachedRoutesPath()
    {
        $path = $this->app->getCachedRoutesPath();

        $this->assertEmpty($path);
    }
}
