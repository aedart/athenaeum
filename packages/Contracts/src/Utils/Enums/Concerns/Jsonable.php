<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

use Aedart\Utils\Json;
use JsonException;

/**
 * Concerns Backed Enum Jsonable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Enums\Concerns
 */
trait Jsonable
{
    use Arrayable;

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
    public static function toJson(int $options = 0): string
    {
        return Json::encode(static::jsonSerialize(), $options);
    }

    /**
     * Returns the data which should be serialized to JSON
     *
     * @return array
     */
    public static function jsonSerialize(): array
    {
        return static::toArray();
    }
}
