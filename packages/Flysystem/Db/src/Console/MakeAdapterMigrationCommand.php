<?php

namespace Aedart\Flysystem\Db\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;

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
    protected $signature = 'flysystem:make-adapter-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new migration file for a Flysystem database adapter';

    /**
     * Creates new adapter migration console command instance
     *
     * @param Composer $composer The composer instance
     */
    public function __construct(
        protected Composer $composer
    )
    {
        parent::__construct();
    }

    /**
     * Executes console command
     *
     * @return void
     */
    public function handle(): void
    {
        // TODO: Obtain adapter type

        // TODO: Obtain table name

        // TODO: Obtain stub and populate it

        // TODO: Migrations path?

        // TODO: Write migration file

        // Dump Composer's autoload
        $this->composer->dumpAutoloads();
    }
}