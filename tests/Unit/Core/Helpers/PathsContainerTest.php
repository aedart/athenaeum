<?php


namespace Aedart\Tests\Unit\Core\Helpers;

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Core\Helpers\Paths;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * PathsContainerTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Core\Helpers
 */
#[Group(
    'core',
    'application',
    'application-helpers',
    'paths-container'
)]
class PathsContainerTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Paths Container instance
     *
     * @param array $data [optional]
     * @return PathsContainer
     *
     * @throws \Throwable
     */
    protected function makePathsContainer(array $data = []): PathsContainer
    {
        return new Paths($data);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @throws \Throwable
     */
    #[Test]
    public function hasDefaultPathsSet()
    {
        $container = $this->makePathsContainer();

        ConsoleDebugger::output($container->toArray());

        $this->assertNotEmpty($container->getBasePath(), 'Base path missing');
        $this->assertNotEmpty($container->getBootstrapPath(), 'Bootstrap path missing');
        $this->assertNotEmpty($container->getConfigPath(), 'Config path missing');
        $this->assertNotEmpty($container->getDatabasePath(), 'Database path missing');
        $this->assertNotEmpty($container->getEnvironmentPath(), 'Environment path missing');
        $this->assertNotEmpty($container->getResourcePath(), 'Resources path missing');
        $this->assertNotEmpty($container->getStoragePath(), 'Storage path missing');
        $this->assertNotEmpty($container->getPublicPath(), 'Public path missing');
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInBaseDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->basePath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getBasePath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInBootstrapDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->bootstrapPath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getBootstrapPath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInConfigDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->configPath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getConfigPath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInDatabaseDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->databasePath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getDatabasePath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInEnvironmentDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->environmentPath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getEnvironmentPath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInResourceDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->resourcePath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getResourcePath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInStorageDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->storagePath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getStoragePath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canResolvePathInPublicDir()
    {
        $container = $this->makePathsContainer();
        $path = $this->getFaker()->word();

        $result = $container->publicPath($path);
        ConsoleDebugger::output($result);

        $expected = $container->getPublicPath() . DIRECTORY_SEPARATOR . $path;
        $this->assertStringContainsString($expected, $result);
    }
}
