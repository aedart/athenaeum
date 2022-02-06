<?php

namespace Aedart\Circuits\Concerns;

use Aedart\Utils\Json;
use JsonException;

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
    public function jsonSerialize(): array
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
    public function __toString(): string
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
