<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Helpers\Paths;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
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
class A2_PathsTest extends AthenaeumCoreTestCase
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
     *
     * @return void
     */
    public function canReadLangPath()
    {
        $path = $this->app->langPath();

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

    /**
     * @test
     */
    public function canReadPublicPath()
    {
        $path = $this->app->publicPath();

        $this->assertNotEmpty($path);
    }

    /*****************************************************************
     * Global Helpers Test
     ****************************************************************/

    /**
     * @test
     */
    public function returnsPathInBaseDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = base_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInBootstrapDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = bootstrap_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInConfigDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = config_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInDatabaseDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = database_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInEnvironmentDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = environment_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInResourceDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = resource_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInStorageDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = storage_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }

    /**
     * @test
     */
    public function returnsPathInPublicDir()
    {
        $path = 'readme.' . $this->getFaker()->fileExtension();

        $result = public_path($path);

        ConsoleDebugger::output($result);

        $this->assertStringContainsString($path, $result);
    }
}
