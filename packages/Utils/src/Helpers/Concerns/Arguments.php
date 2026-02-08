<?php

namespace Aedart\Utils\Helpers\Concerns;

/**
 * Concerns Arguments
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Helpers\Concerns
 */
trait Arguments
{
    /**
     * Arguments to be passed on to callback
     *
     * @var array
     */
    protected array $arguments = [];

    /**
     * Add arguments that must be passed to callback
     *
     * Method merges given arguments with et. already added arguments.
     *
     * @param mixed ...$arguments
     *
     * @return self
     */
    public function with(...$arguments): static
    {
        $this->arguments = array_merge(
            $this->arguments,
            $arguments
        );

        return $this;
    }

    /**
     * Returns the arguments
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}