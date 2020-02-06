<?php


namespace Aedart\Core\Console\Commands;

use Aedart\Support\Helpers\Filesystem\FileTrait;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;

/**
 * Vendor Publish Command
 *
 * Largely inspired by Laravel's "vendor:publish" command, but with less features...
 * @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Console/VendorPublishCommand.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Console\Commands
 */
class PublishCommand extends Command
{
    use FileTrait;

    /**
     * The name and signature
     *
     * @var string
     */
    protected $signature = 'vendor:publish {--force : Overwrite existing files}';

    /**
     * Command description.
     *
     * @var string|null
     */
    protected $description = 'Publish assets from your registered vendor packages';

    /**
     * Execute this command
     *
     * @return int
     */
    public function handle() : int
    {
        return 0;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns the assets to be published
     *
     * @return array list contains "from" and "to" paths
     */
    public function assertsToPublish() : array
    {
        return ServiceProvider::pathsToPublish();
    }
}
