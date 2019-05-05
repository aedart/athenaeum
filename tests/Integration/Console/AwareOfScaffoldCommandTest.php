<?php

namespace Aedart\Tests\Integration\Console;

use Aedart\Console\AwareOfScaffoldCommand;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Codeception\Configuration;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * AwareOfScaffoldCommandTest
 *
 * @group console
 * @group aware-of
 * @group aware-of-scaffold
 * @group aware-of-scaffold-command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Console
 */
class AwareOfScaffoldCommandTest extends IntegrationTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $fs = new Filesystem();
        $fs->deleteDirectory( Configuration::outputDir() . 'aware-of-config/');
    }

    /*****************************************************************
     * Actual Test
     ****************************************************************/

    /**
     * @test
     */
    public function canCreateAwareOfComponents()
    {
        $command = new AwareOfScaffoldCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            '--output' => Configuration::outputDir() . 'aware-of-config/',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        ConsoleDebugger::output($output);

        // --------------------------------------------------------------- //

        $this->assertStringContainsString('[OK]', $output);

        $this->assertFileExists(Configuration::outputDir() . 'aware-of-config/aware-of-properties.php');
    }
}