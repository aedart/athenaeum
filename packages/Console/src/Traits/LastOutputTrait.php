<?php

namespace Aedart\Console\Traits;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Last Output Trait
 *
 * @see \Aedart\Contracts\Console\Output\LastOutputAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Traits
 */
trait LastOutputTrait
{
    /**
     * Last assign console output
     *
     * @var OutputInterface|null
     */
    protected OutputInterface|null $lastOutput = null;

    /**
     * Set last output
     *
     * @param OutputInterface|null $output Last assign console output
     *
     * @return self
     */
    public function setLastOutput(OutputInterface|null $output): static
    {
        $this->lastOutput = $output;

        return $this;
    }

    /**
     * Get last output
     *
     * If no last output has been set, this method will
     * set and return a default last output, if any such
     * value is available
     *
     * @return OutputInterface|null last output or null if none last output has been set
     */
    public function getLastOutput(): OutputInterface|null
    {
        if (!$this->hasLastOutput()) {
            $this->setLastOutput($this->getDefaultLastOutput());
        }
        return $this->lastOutput;
    }

    /**
     * Check if last output has been set
     *
     * @return bool True if last output has been set, false if not
     */
    public function hasLastOutput(): bool
    {
        return isset($this->lastOutput);
    }

    /**
     * Get a default last output value, if any is available
     *
     * @return OutputInterface|null A default last output value or Null if no default value is available
     */
    public function getDefaultLastOutput(): OutputInterface|null
    {
        return null;
    }
}
