<?php

namespace Aedart\Core\Console\Commands;

use Aedart\Support\Helpers\Filesystem\FileTrait;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

/**
 * Publish All Command
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
    protected $signature = 'vendor:publish-all {--force : Overwrite existing assets}';

    /**
     * Command description.
     *
     * @var string|null
     */
    protected $description = 'Publish all assets from your registered vendor packages';

    /**
     * Command help
     *
     * @var string
     */
    protected $help = <<<EOD
A light version of Laravel's vendor:publish command. It is only able to publish all assets or nothing.

<info>How to use</info>
Invoke <comment>{your-cli-app} vendor:publish-all</comment>

All asserts that are set to be published by your registered service providers will be copied into their
specified destinations.

<info>--force flag</info>
<comment>{your-cli-app} vendor:publish-all --force</comment>

Will overwrite existing files.

<options=bold>Note:</> If an entire directory has been specified to be published, then this flag will
have no effect.

<info>Troubleshooting</info>

A common scenario is that you wish to publish assets from a Laravel package, e.g. <comment>illuminate/redis</comment>,
yet no <comment>configs/redis.php</comment> file is created, once you have registered the Service Provider,... etc.
<info>-></info> Not all of Laravel's packages publish resources. You might have to manually copy them from
<href=https://github.com/laravel/laravel/tree/master/config>Laravel's Scaffold Repository</>.

Another common scenario is that assets fail to be published, due to insufficient permissions.
<info>-></info> Please ensure that you have the required write permissions set for those
directories where assets are intended to be published to.

EOD;

    /**
     * Amount published
     *
     * @var int
     */
    protected int $amountPublished = 0;

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

        $this->output->success("{$this->amountPublished} Assets published");

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
            $this->copyFile($from, $to);
            return;
        } elseif ($fs->isDirectory($from)){
            $this->copyDirectory($from, $to);
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
    protected function copyFile(string $from, string $to) : void
    {
        $fs = $this->getFile();

        // Abort if file already exists and force flag if not set
        if($fs->exists($to) && !$this->option('force')){
            $this->markSkipped($to);
            return;
        }

        // Create directory, if required
        $parentDir = $this->fetchOrCreateParentDirectory($to);

        // Finally, copy the file into target destination
        $wasCopied = $fs->copy($from, $to);
        if( ! $wasCopied){
            throw new RuntimeException(sprintf('Unable to copy "%s", please check permissions for "%s"', $from, $parentDir));
        }

        $this->markPublished($to);
    }

    /**
     * Copies a directory and it's content to given target location
     *
     * @param string $from
     * @param string $to
     *
     * @throws RuntimeException
     */
    public function copyDirectory(string $from, string $to) : void
    {
        $fs = $this->getFile();

        // Create directory, if required
        $parentDir = $this->fetchOrCreateParentDirectory($to);

        // NOTE: We do NOT deal with "force" option here.
        // We could by deleting everything from the target location,
        // but that might be dangerous!
        $wasCopied = $fs->copyDirectory($from, $to);
        if( ! $wasCopied){
            throw new RuntimeException(sprintf('Unable to copy "%s", please check permissions for "%s"', $from, $parentDir));
        }

        $this->markPublished($to);
    }

    /**
     * Obtains the parent directory path of given target or creates
     * it if it does not exist.
     *
     * @param string $target
     *
     * @return string Parent directory path
     */
    protected function fetchOrCreateParentDirectory(string $target) : string
    {
        $fs = $this->getFile();

        $parentDir = dirname($target);
        if( ! $fs->isDirectory($parentDir)){
            $fs->makeDirectory($parentDir, 0755, true);
        }

        return $parentDir;
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

        $this->line("<comment>Skipped '</comment>{$asset}<comment>', file already exists</comment>");
    }

    /**
     * Mark asset as "published"
     *
     * @param string $asset Target path where asset is to be located
     */
    protected function markPublished(string $asset) : void
    {
        $this->amountPublished++;

        $asset = $this->shortenPath($asset);

        $this->line("<info>Published '</info>{$asset}<info>'</info>");
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
