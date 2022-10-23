<?php

namespace Aedart\Http\Api\Resources\Concerns;

use Aedart\Utils\Str;

/**
 * Concerns Resource Type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait ResourceType
{
    /**
     * In-memory cache of pluralised resource type(s)
     *
     * @var array
     */
    protected static array $pluralTypes = [];

    /**
     * Returns this resource's name (in singular form)
     *
     * @return string
     */
    abstract public function type(): string;

    /**
     * Returns this resource's name in plural form
     *
     * @return string
     */
    public function pluralType(): string
    {
        $type = $this->type();

        if (isset(static::$pluralTypes[$type])) {
            return static::$pluralTypes[$type];
        }

        return static::$pluralTypes[$type] = Str::plural($type);
    }

    /**
     * Determine if given type matches this resource's type
     *
     * @param  string  $type
     *
     * @return bool
     */
    public function matchesType(string $type): bool
    {
        return $type === $this->type() || $type === $this->pluralType();
    }
}