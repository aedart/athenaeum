<?php

namespace Aedart\Circuits\Concerns;

use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;

/**
 * Concerns Importable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Concerns
 */
trait Importable
{
    /**
     * Populate this state
     *
     * @param array $data
     *
     * @return self
     */
    abstract protected function populate(array $data): static;

    /**
     * @inheritDoc
     *
     * @throws UnknownStateException
     */
    public function __unserialize(array $data): void
    {
        $this->populate($data);
    }
}
