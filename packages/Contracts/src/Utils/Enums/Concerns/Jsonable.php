<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

use JsonException;

/**
 * Concerns Backed Enum Jsonable
 *
 * @see \JsonSerializable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Enums\Concerns
 */
trait Jsonable
{
    /**
     * Returns a JSON representation of this backed enum
     *
     * @param  int  $options  [optional]
     *
     * @return string
     *
     * @throws JsonException
     *
     * @see Json::encode
     */
    public function toJson(int $options = 0): string
    {
        $options |= JSON_THROW_ON_ERROR;

        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Returns data which should be serialized to JSON
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        // Overwrite this method, when your backed enum needs to
        // output more complex data...
        return $this->value;
    }
}
