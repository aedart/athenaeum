<?php

namespace Aedart\Console;

use Aedart\Support\AwareOf\Console\ScaffoldCommand;

/**
 * @deprecated Since version 4.0 - use \Aedart\Support\AwareOf\Console\ScaffoldCommand
 *
 * Aware Of Scaffold Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class AwareOfScaffoldCommand extends ScaffoldCommand
{
    /*****************************************************************
     * Command Configuration
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('dto:scaffold')
            ->setDescription('DEPRECATED - use aware-of scaffold command instead');
    }

    /*****************************************************************
     * Run Command
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function runCommand(): ?int
    {
        trigger_error('Deprecated since v4.0 - use use aware-of scaffold command instead', E_USER_DEPRECATED);

        return parent::runCommand();
    }
}
