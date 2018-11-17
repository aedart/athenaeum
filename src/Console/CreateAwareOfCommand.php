<?php

namespace Aedart\Console;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Create Aware Of Properties Command
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class CreateAwareOfCommand extends CommandBase
{
    /*****************************************************************
     * Command Configuration
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dto:create-aware-of')
            ->setDescription('Generates a series of aware-of components, based on given configuration')
            ->addArgument('config', InputArgument::REQUIRED, 'Path to php configuration file')
            ->setHelp($this->formatHelp());
    }

    /*****************************************************************
     * Run Command
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function runCommand(): ?int
    {
        // TODO: Implement runCommand() method.
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Formats and returns this commands help text
     *
     * @return string
     */
    protected function formatHelp()
    {
        return <<<EOT
Generates a series of aware-of components, based on given configuration

Usage:

<info>php athenaeum dto:create-aware-of my-dto-list.php</info>

EOT;
    }
}
