<?php


namespace Aedart\Tests\Helpers\Dummies\Console\Commands;

use Aedart\Support\Helpers\Logging\LogTrait;
use Illuminate\Console\Command;

/**
 * Does Nothing Command
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Console\Commands
 */
class DoesNothingCommand extends Command
{
    use LogTrait;

    /**
     * Name of command
     *
     * @var string
     */
    protected $name = 'test:does-nothing';

    /**
     * Execute this command
     *
     * @return int
     */
    public function handle()
    {
        $this->getLog()->info('Has done nothing executed');

        $this->output->writeln('Has done nothing');

        return 0;
    }
}
