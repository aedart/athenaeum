<?php

namespace Aedart\Tests\Helpers\Dummies\Console\Commands;

use Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions\CommandFailure;
use Illuminate\Console\Command;

/**
 * Fails Command
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Console\Commands
 */
class FailsCommand extends Command
{
    /**
     * Name of command
     *
     * @var string
     */
    protected $name = 'test:fail';

    /**
     * Execute this command
     */
    public function handle()
    {
        throw new CommandFailure('Test failure...');
    }
}
