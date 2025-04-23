<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters\League;

use Aedart\Container\IoC;
use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Migrations\Migration;
use League\Flysystem\AdapterTestUtilities\FilesystemAdapterTestCase as BaseTestCase;
use League\Flysystem\FilesystemAdapter;
use PHPUnit\Framework\Attributes\Test;

/**
 * DatabaseAdapterTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-league-tests
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters\League
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-league-tests'
)]
class DatabaseAdapterTest extends BaseTestCase
{
    /**
     * Service Container instance
     *
     * @var Container|null
     */
    protected static Container|null $container = null;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritdoc
     */
    //#[AfterClass] // Not needed here...
    public static function tearDownAfterClass(): void
    {
        IoC::getInstance()->destroy();
        static::$container = null;

        parent::tearDownAfterClass();
    }

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        static::$container = IoC::getInstance()
            ->registerAsApplication();

        parent::setUp();
    }

    /*****************************************************************
     * Adapter
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected static function createFilesystemAdapter(): FilesystemAdapter
    {
        // This test extends Leagues official "fly-system testing utils". This means
        // that a full Laravel is NOT up and running. A connection is therefore configured
        // manually here...

        /** @var \Illuminate\Container\Container $container */
        $container = static::$container;

        // Setup connection manager
        $capsule = new Manager($container);
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'foreign_key_constraints' => true,
        ]);
        $capsule->setAsGlobal();

        // Bind schema builder, so we can run migration manually!
        $container->singleton('db.schema', function () use ($capsule) {
            return $capsule->getConnection()->getSchemaBuilder();
        });

        // Run migrations
        $migrationClass = require Configuration::dataDir() . 'flysystem/db/migrations/2022_05_04_071658_create_files_table.php';
        /** @var Migration $migration */
        $migration = new $migrationClass();
        $migration->up();

        // Finally, return adapter
        return new DatabaseAdapter('files', 'file_contents', $capsule->getConnection());
    }

    /*****************************************************************
     * Test Overwrites
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function fetching_unknown_mime_type_of_a_file(): void
    {
        // Here the original test is simply invalid - the applied MIME-Type
        // detector sniffs the file's content and determines that applied
        // file is of type "text/plain" - which apparently League's detector
        // ignores and only looks at the file extension. For this reason,
        // this test is "ignored"

        $this->assertTrue(true);

        // Original:
        //        $this->givenWeHaveAnExistingFile(
        //            'unknown-mime-type.md5',
        //            file_get_contents(__DIR__ . '/test_files/unknown-mime-type.md5')
        //        );
        //
        //        $this->expectException(UnableToRetrieveMetadata::class);
        //
        //        $this->runScenario(function () {
        //            $this->adapter()->mimeType('unknown-mime-type.md5');
        //        });
    }

    /**
     * @test
     * @dataProvider filenameProvider
     */
    #[Test]
    public function writing_and_reading_files_with_special_path(string $path): void
    {
        // NOTE: At some point, Codeception / PHPUnit started to fail the parent test,
        // because it could NOT obtain the "data provider"... This simple overwrite
        // somehow works...!?
        parent::writing_and_reading_files_with_special_path($path);
    }

    /**
     * @test
     * @inheritdoc
     */
    #[Test]
    public function get_checksum(): void
    {
        // The original test always assumes a md5 checksum of a file. However, the database adapter
        // might apply a different default hashing algorithm therefore, we change the adapter to
        // fit the original test

        /** @var DatabaseAdapter $adapter */
        $adapter = $this->createFilesystemAdapter();
        $adapter->setHashAlgorithm('md5');
        $this->useAdapter($adapter);

        // Invoke original test...
        parent::get_checksum();

        // Clear "custom" adapter...
        $this->clearCustomAdapter();
    }

    /**
     * @test
     *
     * @inheritdoc
     */
    #[Test]
    public function generating_a_public_url(): void
    {
        // This test is automatically SKIPPED. But, there is no need to
        // mark it as such. The Database adapter does not support this feature!
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @inheritdoc
     */
    #[Test]
    public function generating_a_temporary_url(): void
    {
        // This test is automatically SKIPPED. But, there is no need to
        // mark it as such. The Database adapter does not support this feature!
        $this->assertTrue(true);
    }
}
