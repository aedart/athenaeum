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
     * @var array<class-string<Precondition>|Precondition>
     */
    protected array $preconditions = [];

    /**
     * @inheritdoc
     */
    public function setPreconditions(array $preconditions): static
    {
        $this->preconditions = array_values($preconditions);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPreconditions(): array
    {
        return $this->preconditions;
    }

    /**
     * @inheritdoc
     */
    public function preconditions(): array
    {
        return $this->getPreconditions();
    }

    /**
     * @inheritdoc
     */
    public function addPrecondition(string|Precondition $precondition): static
    {
        $this->preconditions[] = $precondition;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clearPreconditions(): static
    {
        $this->preconditions = [];

        return $this;
    }
}
