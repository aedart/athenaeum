<?php

namespace Aedart\Tests\Integration\Console;

use Aedart\Support\AwareOf\Console\ScaffoldCommand;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * AwareOfScaffoldCommandTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Console
 */
#[Group(
    'console',
    'aware-of',
    'aware-of-scaffold',
    'aware-of-scaffold-command',
)]
class AwareOfScaffoldCommandTest extends IntegrationTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $fs = new Filesystem();
        $fs->deleteDirectory(Configuration::outputDir() . 'aware-of-config/');
    }

    /*****************************************************************
     * Actual Test
     ****************************************************************/

    #[Test]
    public function canCreateAwareOfComponents()
    {
        $command = new ScaffoldCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--output' => Configuration::outputDir() . 'aware-of-config/',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        ConsoleDebugger::output($output);

        // --------------------------------------------------------------- //

        $this->assertStringContainsString('[OK]', $output);

        $this->assertFileExists(Configuration::outputDir() . 'aware-of-config/aware-of-properties.php');
    }
}
