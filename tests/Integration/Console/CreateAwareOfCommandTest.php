<?php

namespace Aedart\Tests\Integration\Console;

use Aedart\Support\AwareOf\Console\CreateCommand;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * CreateAwareOfCommandTest
 *
 * @group console
 * @group aware-of
 * @group aware-of-command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Console
 */
#[Group(
    'console',
    'aware-of',
    'aware-of-command',
)]
class CreateAwareOfCommandTest extends IntegrationTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $fs = new Filesystem();
        $fs->deleteDirectory(Configuration::outputDir() . 'aware-of/');
    }


    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Assert the given aware of component exists
     *
     * @param string $path
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    protected function assertAwareOfComponentExists(string $path)
    {
        $prefix = Configuration::outputDir() . 'aware-of/';

        // Determine if exists
        $this->assertFileExists($prefix . $path);

        // Attempt to include component. PHP will fail if something
        // is off.
        require $prefix . $path;
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    #[Test]
    public function canCreateAwareOfComponents()
    {
        $command = new CreateCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'config' => Configuration::dataDir() . 'configs/aware-of-command/demo.php',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        ConsoleDebugger::output($output);

        // --------------------------------------------------------------- //

        $this->assertStringContainsString('[OK]', $output);

        $this->assertAwareOfComponentExists('Contracts/Arrays/CategoriesAware.php');
        $this->assertAwareOfComponentExists('Traits/Arrays/CategoriesTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Booleans/IsDestroyedAware.php');
        $this->assertAwareOfComponentExists('Traits/Booleans/IsDestroyedTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Callables/CallbackAware.php');
        $this->assertAwareOfComponentExists('Traits/Callables/CallbackTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Dates/CreatedAtAware.php');
        $this->assertAwareOfComponentExists('Traits/Dates/CreatedAtTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Floats/PriceAware.php');
        $this->assertAwareOfComponentExists('Traits/Floats/PriceTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Integers/AgeAware.php');
        $this->assertAwareOfComponentExists('Traits/Integers/AgeTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Iterators/PersonsAware.php');
        $this->assertAwareOfComponentExists('Traits/Iterators/PersonsTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Mixes/PlayerAware.php');
        $this->assertAwareOfComponentExists('Traits/Mixes/PlayerTrait.php');

        $this->assertAwareOfComponentExists('Contracts/Strings/NameAware.php');
        $this->assertAwareOfComponentExists('Traits/Strings/NameTrait.php');

        $this->assertFileExists(Configuration::outputDir() . 'aware-of/README.md');
    }
}
