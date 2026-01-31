<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Aedart\Utils\Str;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * MakeAdapterMigrationCommandTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Console
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-console'
)]
class MakeAdapterMigrationCommandTest extends FlysystemDbTestCase
{
    /**
     * State whether migrations should be installed or not
     *
     * @var bool
     */
    protected bool $installAdapterMigrations = false;

    /**
     * @return void
     */
    #[Test]
    public function commandIsRegisteredInArtisan()
    {
        $this
            ->artisan(self::MAKE_MIGRATION_CMD, [
                '-h'
            ])
            ->assertSuccessful();
    }

    /**
     * @return void
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    #[Test]
    public function canCreateDefaultAdapterMigrationFile()
    {
        $this
            ->artisan(self::MAKE_MIGRATION_CMD, [
                '--files-table' => 'files',
                '--contents-table' => 'files_contents',
                '--path' => $this->migrationsOutputPath()
            ])
            ->assertSuccessful();

        // ------------------------------------------------------------------------------------- //

        $fs = $this->getFile();
        $files = $fs->files($this->outputDir());

        ConsoleDebugger::output($files);

        $this->assertNotEmpty($files, 'No migration files published');

        // ------------------------------------------------------------------------------------- //

        $wasCreated = false;
        foreach ($files as $file) {
            if (Str::endsWith($file->getBasename(), 'create_files_table.php')) {
                $wasCreated = true;
                break;
            }
        }

        $this->assertTrue($wasCreated, 'Migration file does not appear to be created by command');
    }
}
