<?php


namespace Aedart\Contracts\Database\Models;

/**
 * Instantiatable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Database\Models
 */
interface Instantiatable
{
    /**
     * Create a new instance of this model
     *
     * @param array $attributes [optional]
     * @param string|null $connection [optional]
     *
     * @return static
     */
    public static function make(array $attributes = [], string|null $connection = null): static;
}
