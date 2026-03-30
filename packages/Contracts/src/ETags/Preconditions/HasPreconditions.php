<?php

namespace Aedart\Contracts\ETags\Preconditions;

/**
 * Has Preconditions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface HasPreconditions
{
    /**
     * Set preconditions
     *
     * @param  array<class-string<Precondition>|Precondition>  $preconditions List of class paths or {@see Precondition} instances
     *
     * @return self
     */
    public function setPreconditions(array $preconditions): static;

    /**
     * Get preconditions
     *
     * @return array<class-string<Precondition>|Precondition> List of class paths or {@see Precondition} instances
     */
    public function getPreconditions(): array;

    /**
     * Alias for {@see getPreconditions()}
     *
     * @return array<class-string<Precondition>|Precondition>
     */
    public function preconditions(): array;

    /**
     * Add a new precondition at the end of the list of preconditions
     *
     * @param  class-string<Precondition>|Precondition  $precondition Class path or {@see Precondition} instance
     *
     * @return static
     */
    public function addPrecondition(string|Precondition $precondition): static;

    /**
     * Clear all preconditions
     *
     * @return static
     */
    public function clearPreconditions(): static;
}
