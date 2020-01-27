<?php

namespace Aedart\Contracts\Console\Output;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Last Output Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Console\Output
 */
interface LastOutputAware
{
    /**
     * Set last output
     *
     * @param OutputInterface|null $output Last assign console output
     *
     * @return self
     */
    public function setLastOutput(?OutputInterface $output);

    /**
     * Get last output
     *
     * If no last output has been set, this method will
     * set and return a default last output, if any such
     * value is available
     *
     * @return OutputInterface|null last output or null if none last output has been set
     */
    public function getLastOutput(): ?OutputInterface;

    /**
     * Check if last output has been set
     *
     * @return bool True if last output has been set, false if not
     */
    public function hasLastOutput(): bool;

    /**
     * Get a default last output value, if any is available
     *
     * @return OutputInterface|null A default last output value or Null if no default value is available
     */
    public function getDefaultLastOutput(): ?OutputInterface;
}
