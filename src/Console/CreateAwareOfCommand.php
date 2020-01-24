<?php

namespace Aedart\Console;

use Aedart\Support\AwareOf\Console\CreateCommand;

/**
 * @deprecated Since version 4.0 - use \Aedart\Support\AwareOf\Console\CreateCommand
 *
 * Create Aware Of Properties Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class CreateAwareOfCommand extends CreateCommand
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
            ->setName('dto:create-aware-of')
            ->setDescription('DEPRECATED - use dto:create create command instead. See \Aedart\Support\AwareOf\Console\CreateCommand');
    }

    /*****************************************************************
     * Run Command
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function runCommand(): ?int
    {
        trigger_error('Deprecated since v4.0 - use use dto:create command instead. See \Aedart\Support\AwareOf\Console\CreateCommand', E_USER_DEPRECATED);

        return parent::runCommand();
    }
}
