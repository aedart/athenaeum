<?php


namespace Aedart\Database\Models\Concerns;

/**
 * Concerns Instance
 *
 * @see \Aedart\Contracts\Database\Models\Instantiatable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Database\Models\Concerns
 */
trait Instance
{
    /**
     * Create a new instance of this model
     *
     * @param array $attributes [optional]
     * @param string|null $connection [optional]
     *
     * @return static
     */
    public static function make(array $attributes = [], string|null $connection = null): static
    {
        return (new static($attributes))
            ->setConnection($connection);
    }
}
