<?php

namespace Aedart\Console\Traits;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Last Input Trait
 *
 * @see \Aedart\Contracts\Console\Input\LastInputAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Traits
 */
trait LastInputTrait
{
    /**
     * Last captured console input
     *
     * @var InputInterface|null
     */
    protected InputInterface|null $lastInput = null;

    /**
     * Set last input
     *
     * @param InputInterface|null $input Last captured console input
     *
     * @return self
     */
    public function setLastInput(InputInterface|null $input): static
    {
        $this->lastInput = $input;

        return $this;
    }

    /**
     * Get last input
     *
     * If no last input has been set, this method will
     * set and return a default last input, if any such
     * value is available
     *
     * @return InputInterface|null last input or null if none last input has been set
     */
    public function getLastInput(): InputInterface|null
    {
        if (!$this->hasLastInput()) {
            $this->setLastInput($this->getDefaultLastInput());
        }
        return $this->lastInput;
    }

    /**
     * Check if last input has been set
     *
     * @return bool True if last input has been set, false if not
     */
    public function hasLastInput(): bool
    {
        return isset($this->lastInput);
    }

    /**
     * Get a default last input value, if any is available
     *
     * @return InputInterface|null A default last input value or Null if no default value is available
     */
    public function getDefaultLastInput(): InputInterface|null
    {
        return null;
    }
}
