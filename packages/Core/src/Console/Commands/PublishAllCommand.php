<?php

namespace Aedart\Core\Console\Commands;

use Aedart\Support\Helpers\Filesystem\FileTrait;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

/**
 * Vendor Publish Command
 *
 * Largely inspired by Laravel's "vendor:publish" command, but with less features...
 * @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Console/VendorPublishCommand.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Console\Commands
 */
class PublishAllCommand extends Command
{
    use FileTrait;

    /**
     * The name and signature
     *
     * @var string
     */
    protected $signature = 'vendor:publish {--force : Overwrite existing assets}';

    /**
     * Command description.
     *
     * @var string|null
     */
    protected $description = 'Publish assets from your registered vendor packages';

    /**
     * Command help
     *
     * @var string
     */
    protected $help = 'Light version of Laravel\'s vendor:publish command. Is only able to publish all assets or nothing.';

    /**
     * Execute this command
     *
     * @return int
     */
    public function handle() : int
    {
        $assets = $this->assertsToPublish();

        foreach ($assets as $from => $to){
            $this->publish($from, $to);
        }

        $this->output->success('Assets published');

        return 0;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Publish asset to given target location
     *
     * @param string $from
     * @param string $to
     *
     * @throws RuntimeException
     */
    protected function publish(string $from, string $to) : void
    {
        $fs = $this->getFile();

        if($fs->isFile($from)){
            $this->publishFile($from, $to);
            return;
        } elseif ($fs->isDirectory($from)){
            $this->publishDirectory($from, $to);
            return;
        }

        throw new RuntimeException(sprintf('Unable to publish "%s", please check if package contains asset in your vendor directory', $from));
    }

    /**
     * Copies a file to given target location
     *
     * @param string $from
     * @param string $to
     *
     * @throws RuntimeException
     */
    protected function publishFile(string $from, string $to) : void
    {
        $fs = $this->getFile();

        // Abort if file already exists and force flag if not set
        if($fs->exists($to) && !$this->option('force')){
            $this->markSkipped($to);
            return;
        }

        // Create directory, if required
        $parentDir = dirname($to);
        if( ! $fs->isDirectory($parentDir)){
            $fs->makeDirectory($parentDir, 0755, true);
        }

        // Finally, copy the file into target destination
        $wasCopied = $fs->copy($from, $to);
        if( ! $wasCopied){
            throw new RuntimeException(sprintf('Unable to publish "%s", please check permissions for "%s"', $from, $parentDir));
        }

        $this->markPublished($to);
    }

    // TODO:
    public function publishDirectory(string $from, string $to) : void
    {
        $fs = $this->getFile();

        // TODO: fs->copyDirectory();
    }

    /**
     * Returns the assets to be published
     *
     * @return array list contains "from" and "to" paths
     */
    protected function assertsToPublish() : array
    {
        return ServiceProvider::pathsToPublish();
    }

    /**
     * Mark asset as "skipped"
     *
     * @param string $asset Target path where asset is to be located
     */
    protected function markSkipped(string $asset) : void
    {
        $asset = $this->shortenPath($asset);

        $this->warn("Skipping '{$asset}', file already exists");
    }

    /**
     * Mark asset as "published"
     *
     * @param string $asset Target path where asset is to be located
     */
    protected function markPublished(string $asset) : void
    {
        $asset = $this->shortenPath($asset);

        $this->info("'{$asset}' published");
    }

    /**
     * Shortens the given assets path (for output purposes)
     *
     * @param string $asset
     *
     * @return string
     */
    protected function shortenPath(string $asset) : string
    {
        return str_replace(getcwd(), '', $asset);
    }
}
