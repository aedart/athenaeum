<?php


namespace Aedart\Tests\Unit\Core\Helpers;

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Core\Helpers\Paths;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;

/**
 * PathsContainerTest
 *
 * @group core
 * @group application
 * @group application-helpers
 * @group paths-container
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Core\Helpers
 */
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
    protected function makePathsContainer(array $data = []) : PathsContainer
    {
        return new Paths($data);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function hasDefaultPathsSet()
    {
        $paths = $this->makePathsContainer();

        ConsoleDebugger::output($paths->toArray());

        $this->assertNotEmpty($paths->getBasePath(), 'Base path missing');
        $this->assertNotEmpty($paths->getBootstrapPath(), 'Bootstrap path missing');
        $this->assertNotEmpty($paths->getConfigPath(), 'Config path missing');
        $this->assertNotEmpty($paths->getDatabasePath(), 'Database path missing');
        $this->assertNotEmpty($paths->getEnvironmentPath(), 'Environment path missing');
        $this->assertNotEmpty($paths->getResourcePath(), 'Resources path missing');
        $this->assertNotEmpty($paths->getStoragePath(), 'Storage path missing');
    }
}
