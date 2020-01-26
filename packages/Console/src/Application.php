<?php

namespace Aedart\Console;

use Aedart\Utils\Version;
use Illuminate\Console\Application as LaravelConsoleApplication;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Console Application
 *
 * Extended version of Laravel's Artisan Console Application
 *
 * @see \Illuminate\Console\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class Application extends LaravelConsoleApplication
{
    /**
     * @inheritdoc
     */
    public function __construct(Container $laravel, Dispatcher $events, $version)
    {
        parent::__construct($laravel, $events, $version);

        $this->setName(sprintf('Athenaeum (via. Laravel ~ Illuminate/console v.%s)', $this->laravelVersion()));
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns the current installed Laravel Console package version
     *
     * @return string
     */
    protected function laravelVersion() : string
    {
        return Version::package('illuminate/console');
    }
}
