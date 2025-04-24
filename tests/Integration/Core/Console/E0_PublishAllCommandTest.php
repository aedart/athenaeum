<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;

/**
 * E0_PublishAllCommandTest
 *
 * @group application
 * @group application-console
 * @group application-console-e0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
#[Group(
    'application',
    'application-console',
    'application-console-e0',
)]
class E0_PublishAllCommandTest extends AthenaeumCoreConsoleTestCase
{
    use FileTrait;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        $fs = $this->getFile();
        $target = $this->targetPublishDir();
        if ($fs->isDirectory($target)) {
            $fs->cleanDirectory($target);
        }
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Target output dir of publish command
     *
     * @return string
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function targetPublishDir()
    {
        return Configuration::outputDir() . 'console/publish/';
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function hasRegisteredPublishAllCommand()
    {
        $console = $this->getArtisan();

        $commands = $console->all();
        $names = array_keys($commands);

        ConsoleDebugger::output($names);

        $this->assertTrue(in_array('vendor:publish-all', $names));
    }

    /**
     * @test
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    #[Test]
    public function canPublishAssets()
    {
        // NOTE: The following has no affect at this point!
        //$this->app->getPathsContainer()->configPath( $this->targetPublishDir() );

        $exitCode = $this
            ->withoutMockingConsoleOutput()
            ->artisan('vendor:publish-all');

        $this->assertSame(0, $exitCode, 'Invalid exit code');

        // ------------------------------------------------------------ //
        // Ensure that assets have been copied.
        // NOTE: We only check for the directories published by AssetsServiceProvider,
        // because we are unable to affect the output directories at runtime,
        // for the configuration files.
        // @see \Aedart\Tests\Helpers\Dummies\Core\Providers\AssetsServiceProvider
        $fs = $this->getFile();

        $target = $this->targetPublishDir();
        $targetA = $target . 'athenaeum';
        $targetB = $target . 'templates';

        $this->assertTrue($fs->isDirectory($target), 'Output dir not created');
        $this->assertTrue($fs->isDirectory($targetA), 'Nested resource A not published');
        $this->assertTrue($fs->isDirectory($targetB), 'Nested resource B not published');

        // Ensure directories are not empty
        $filesInA = $fs->allFiles($targetA);
        //ConsoleDebugger::output($filesInA);
        $this->assertNotEmpty($filesInA, 'target A has no files published');

        $filesInB = $fs->allFiles($targetB);
        //ConsoleDebugger::output($filesInB);
        $this->assertNotEmpty($filesInB, 'target B has no files published');

        // ------------------------------------------------------------ //

        $output = $this->getArtisan()->output();
        ConsoleDebugger::output($output);

        $this->assertStringContainsString('Assets published', $output);
    }
}
