<?php

namespace Aedart\Circuits\Concerns;

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
     */
    abstract protected function populate(array $data);

    /**
     * @inheritDoc
     */
    public function __unserialize(array $data): void
    {
        $this->populate($data);
    }
}
