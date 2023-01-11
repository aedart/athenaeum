<?php

namespace Aedart\ETags\Preconditions\Concerns;

use Aedart\Contracts\ETags\Preconditions\Precondition;

/**
 * Concerns Preconditions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Concerns
 */
trait Preconditions
{
    /**
     * List of preconditions
     *
     * @var string[]|Precondition[]
     */
    protected array $preconditions = [];

    /**
     * Set preconditions
     *
     * @param  string[]|Precondition[]  $preconditions List of class paths or {@see Precondition} instances
     *
     * @return self
     */
    public function setPreconditions(array $preconditions): static
    {
        $this->preconditions = array_values($preconditions);

        return $this;
    }

    /**
     * Get preconditions
     *
     * @return string[]|Precondition[] List of class paths or {@see Precondition} instances
     */
    public function getPreconditions(): array
    {
        return $this->preconditions;
    }

    /**
     * Alias for {@see getPreconditions()}
     *
     * @return string[]|Precondition[]
     */
    public function preconditions(): array
    {
        return $this->getPreconditions();
    }

    /**
     * Add a new precondition at the end of the list of preconditions
     *
     * @param  string|Precondition  $precondition Class path or {@see Precondition} instance
     *
     * @return static
     */
    public function addPrecondition(string|Precondition $precondition): static
    {
        $this->preconditions[] = $precondition;

        return $this;
    }

    /**
     * Clear all preconditions
     *
     * @return static
     */
    public function clearPreconditions(): static
    {
        $this->preconditions = [];

        return $this;
    }
}