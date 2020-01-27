<?php

namespace Aedart\Contracts\Console\Input;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Last Input Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Console\Input
 */
interface LastInputAware
{
    /**
     * Set last input
     *
     * @param InputInterface|null $input Last captured console input
     *
     * @return self
     */
    public function setLastInput(?InputInterface $input);

    /**
     * Get last input
     *
     * If no last input has been set, this method will
     * set and return a default last input, if any such
     * value is available
     *
     * @return InputInterface|null last input or null if none last input has been set
     */
    public function getLastInput(): ?InputInterface;

    /**
     * Check if last input has been set
     *
     * @return bool True if last input has been set, false if not
     */
    public function hasLastInput(): bool;

    /**
     * Get a default last input value, if any is available
     *
     * @return InputInterface|null A default last input value or Null if no default value is available
     */
    public function getDefaultLastInput(): ?InputInterface;
}
