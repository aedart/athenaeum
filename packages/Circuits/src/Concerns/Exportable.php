<?php

namespace Aedart\Circuits\Concerns;

use Aedart\Utils\Json;

/**
 * Concerns Exportable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Concerns
 */
trait Exportable
{
    /**
     * @inheritDoc
     *
     * @throws JsonException
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->toArray(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function __serialize(): array
    {
        return $this->toArray();
    }

    /**
     * Returns a string representation
     *
     * @return string
     *
     * @throws JsonException
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Debug info
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }
}
