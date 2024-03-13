<?php

namespace Aedart\Support\AwareOf\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

/**
 * Command Base
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\AwareOf\Console
 */
abstract class CommandBase extends Command
{
    /**
     * This command's input
     *
     * @var InputInterface
     */
    protected InputInterface $input;

    /**
     * This command's output
     *
     * @var OutputInterface|StyleInterface
     */
    protected OutputInterface|StyleInterface $output;

    /**
     * {@inheritdoc}
     *
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Set input
        $this->input = $input;

        // Resolve output
        if ($output instanceof StyleInterface) {
            $this->output = $output;
        } else {
            $this->output = new SymfonyStyle($this->input, $output);
        }

        // Finally, run the command
        return $this->runCommand();
    }

    /*****************************************************************
     * Abstract Methods
     ****************************************************************/

    /**
     * Execute this command
     *
     * @throws Throwable
     *
     * @return int|null
     */
    abstract public function runCommand(): int|null;
}
