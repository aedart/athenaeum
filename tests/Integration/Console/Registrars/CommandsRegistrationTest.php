<?php

namespace Aedart\Tests\Integration\Console\Registrars;

use Aedart\Console\Commands\PirateTalkCommand;
use Aedart\Console\Providers\ConsoleServiceProvider;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\LaravelTestCase;
use Illuminate\Contracts\Console\Kernel;

/**
 * CommandsRegistrarTest
 *
 * @group console
 * @group commands-registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Console\Registrars
 */
class CommandsRegistrationTest extends LaravelTestCase
{
    use ConfigTrait;
    use ArtisanTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        $this->addCommandsToConfig();
    }

    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class
        ];
    }

    /**
     * Adds commands to the configuration
     */
    protected function addCommandsToConfig()
    {
        $this->getConfig()->set('commands', [
            PirateTalkCommand::class
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function hasRegisteredCommandFromConfig()
    {
        $commands = $this->getArtisan()->all();
        $commandNames = array_keys($commands);

        sort($commandNames);
        ConsoleDebugger::output($commandNames);

        $this->assertTrue(in_array('pirate:talk', $commandNames));
    }

    /**
     * @test
     *
     * @depends hasRegisteredCommandFromConfig
     */
    public function canExecuteRegisteredCommand()
    {
        $command = $this->artisan('pirate:talk');

        $command
            ->assertExitCode(0)
            ->run();

        $output = $this->getArtisan()->output();
        ConsoleDebugger::output($output);

        $this->assertNotEmpty($output);
    }

}
