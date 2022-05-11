<?php

namespace Aedart\Flysystem\Db\Console;

use Illuminate\Console\Command;
use InvalidArgumentException;
use RuntimeException;

/**
 * Make Adapter Migration Command
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Console
 */
class MakeAdapterMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flysystem:make-adapter-migration
                            {--files-table= : Name of the "files" table to hold files.}
                            {--contents-table= : Name of the "files" table to hold files.}
                            {--path= : Path to where migration file must be created (Relative to project root). Defaults to Laravel\'s default migrations directory}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new migration file for a Flysystem database adapter';

    /**
     * Executes console command
     *
     * @return void
     */
    public function handle(): void
    {
        $this->output->title('Create new database adapter migration file');

        // Resolve table names
        $filesTable = $this->resolveFilesTableName();
        $contentsTable = $this->resolveContentsTableName();
        if ($filesTable == $contentsTable){
            Throw new InvalidArgumentException(sprintf('"Files" and "contents" table names the same (%s == %s). Unable to create migration file!', $filesTable, $contentsTable));
        }

        // Write migration file
        $type = 'default';
        $this->writeMigrationFile($type, $filesTable, [
            'files_table' => $filesTable,
            'contents_table' => $contentsTable,
        ]);

        // Done...
        $this->output->success([
            'Migration file created',

            <<<EOF
Please add appropriate storage disk profile, in your `config/filesystems.php` configuration.
Example:

'disks' => [

    // ...previous not shown...

    'database' => [
        'driver' => 'database',
        'connection' => env('DB_CONNECTION', 'mysql'),
        'files_table' => '{$filesTable}',
        'contents_table' => '{$contentsTable}',
        'hash_algo' => 'sha256',
        'path_prefix' => '',
        'throw' => true
    ]
],
EOF,
            'Run `php artisan migrate` to install new migration',
            'Run `composer dump-autoload` if the migration is not automatically detected by Laravel!'
        ]);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve the "files" table name
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function resolveFilesTableName(): string
    {
        return $this->resolveTableName('files-table', 'Name of "files" table?');
    }

    /**
     * Resolve the "files contents" table name
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function resolveContentsTableName(): string
    {
        return $this->resolveTableName('contents-table', 'Name of "files" table?');
    }

    /**
     * Resolves a table name for given console argument
     *
     * @param string $argument Name of console argument
     * @param string $question [optional]
     * @param string|null $default [optional] Default value
     *
     * @return string
     */
    protected function resolveTableName(string $argument, string $question = 'Table name?', string|null $default = null): string
    {
        $validation = function($answer) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z\p{N}_]{0,127}$/', $answer)) {
                throw new InvalidArgumentException('Invalid table name provided. Please try again...');
            }

            return $answer;
        };

        // Obtain argument (table name) or ask for it
        $name = $this->option($argument);
        if (!isset($name)) {
            $name = $this->output->ask($question, $default, $validation);
        }

        // (Re)validate table name, when provided as option.
        $validation($name);

        return strtolower(trim($name));
    }

    /**
     * Resolves path where migration file must be created
     *
     * @return string
     */
    protected function resolveMigrationsPath(): string
    {
        $path = $this->option('path');

        if (!isset($path)) {
            return $this->getLaravel()->databasePath('migrations');
        }

        return $this->getLaravel()->basePath($path);
    }

    /**
     * Creates the migration file
     *
     * @param string $type
     * @param string $table
     * @param array $data
     *
     * @return void
     */
    protected function writeMigrationFile(string $type, string $table, array $data): void
    {
        $populated = $this->populateStub(
            $this->getMigrationStub($type),
            $data
        );

        $filename = $this->makeMigrationFilename($table, $this->resolveMigrationsPath());

        $result = file_put_contents($filename, $populated);
        if ($result === false) {
            throw new RuntimeException(sprintf('Unable to write migration file: %s. Please check your permissions!', $filename));
        }
    }

    /**
     * Populate the migration stub with data
     *
     * @param string $stub
     * @param array $data
     *
     * @return string
     */
    protected function populateStub(string $stub, array $data): string
    {
        foreach ($data as $key => $value) {
            $stub = str_replace([ "{{ {$key} }}", "{{{$key}}}" ], $value, $stub);
        }

        return $stub;
    }

    /**
     * Returns the migration stub's content, for given adapter type
     *
     * @param string $type Adapter type
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected function getMigrationStub(string $type): string
    {
        $path = realpath($this->stubsPath() . "/{$type}.stub");

        if (!file_exists($path)) {
            throw new RuntimeException(sprintf('Unable to find migration stub: %s', $path));
        }

        return file_get_contents($path);
    }

    /**
     * Returns path to stubs directory
     *
     * @return string
     */
    protected function stubsPath(): string
    {
        return __DIR__ . '/../../stubs';
    }

    /**
     * Makes migration filename for given table
     *
     * @param string $table
     * @param string $path
     *
     * @return string
     */
    protected function makeMigrationFilename(string $table, string $path): string
    {
        return $path . DIRECTORY_SEPARATOR . date('Y_m_d_His') . '_create_' . $table . '_table.php';
    }
}