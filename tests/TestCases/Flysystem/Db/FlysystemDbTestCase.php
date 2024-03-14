<?php

namespace Aedart\Tests\TestCases\Flysystem\Db;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Aedart\Flysystem\Db\Providers\FlysystemDatabaseAdapterServiceProvider;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Testing\Laravel\Database\TestingConnection;
use Aedart\Tests\TestCases\Flysystem\FlysystemTestCase;
use Codeception\Configuration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

/**
 * Flysystem Db Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Flysystem\Db
 */
abstract class FlysystemDbTestCase extends FlysystemTestCase
{
    use FileTrait;

    /**
     * Name of the console command
     */
    public const MAKE_MIGRATION_CMD = 'flysystem:make-adapter-migration';

    /**
     * State whether migrations should be installed or not
     *
     * @var bool
     */
    protected bool $installAdapterMigrations = true;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Clean some directories
        $fs = $this->getFile();
        $outputDir = $this->outputDir();

        $fs->ensureDirectoryExists($outputDir);
        $fs->cleanDirectory($outputDir);

        // Run migrations
        if ($this->installAdapterMigrations) {
            $this->installFilesystemMigrations();
        }
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        parent::_after();
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        TestingConnection::enableConnection();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            FlysystemDatabaseAdapterServiceProvider::class
        ];
    }

    /**
     * Runs the database migrations for the filesystem package
     *
     * @return self
     */
    public function installFilesystemMigrations(): self
    {
        // Install default migrations
        $this->loadLaravelMigrations();

        // Install custom migrations
        $this->loadMigrationsFrom(
            [
                '--path' => $this->migrations(),
                '--realpath' => true
            ]
        );

        return $this;
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function migrations(): string
    {
        return Configuration::dataDir() . 'flysystem/db/migrations';
    }

    /**
     * Returns relative path to migrations directory
     *
     * @return string
     */
    public function migrationsOutputPath(): string
    {
        // Note: path is relative to the 'vendor/orchestra/testbench-core/laravel/' directory!
        // This is needed for the "make adapter migration" command. Current version does not
        // support real-path!
        return '../../../../tests/_output/flysystem/db';
    }

    /**
     * Returns path to output directory
     *
     * @return string
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function outputDir(): string
    {
        return Configuration::outputDir() . 'flysystem/db';
    }

    /**
     * Creates a new filesystem instance, using the database adapter
     *
     * @param string $pathPrefix [optional]
     * @param DatabaseAdapter|null $adapter [optional] Evt. custom adapter.
     *
     * @return FilesystemOperator
     */
    public function filesystem(string $pathPrefix = '', DatabaseAdapter|null $adapter = null): FilesystemOperator
    {
        $adapter = $adapter ?? new DatabaseAdapter('files', 'file_contents', null);
        $adapter
            ->setPathPrefix($pathPrefix);

        return new Filesystem($adapter);
    }

    /**
     * Fetch all file records
     *
     * @return Collection
     */
    public function fetchAllFiles(): Collection
    {
        return DB::table('files')
            ->select()
            ->where('type', RecordTypes::FILE->value)
            ->get();
    }

    /**
     * Fetch all directory records
     *
     * @return Collection
     */
    public function fetchAllDirectories(): Collection
    {
        return DB::table('files')
            ->select()
            ->where('type', RecordTypes::DIRECTORY->value)
            ->get();
    }

    /**
     * Fetch all file contents records
     *
     * @return Collection
     */
    public function fetchAllFileContents(): Collection
    {
        return DB::table('file_contents')
            ->select()
            ->get();
    }

    /**
     * Creates given list of directories
     *
     * @param array $directories
     * @param string $pathPrefix [optional]
     *
     * @return void
     *
     * @throws FilesystemException
     */
    public function createDirectories(array $directories, string $pathPrefix = ''): void
    {
        $fs = $this->filesystem($pathPrefix);

        foreach ($directories as $directory) {
            $fs->createDirectory($directory);
        }
    }
}
