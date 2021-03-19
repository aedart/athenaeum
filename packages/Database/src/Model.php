<?php

namespace Aedart\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Model
 *
 * Extended version of Eloquent model
 *
 * @see \Illuminate\Database\Eloquent\Model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database
 */
abstract class Model extends BaseModel
{
    /**
     * Create a new instance of this model
     *
     * @param array $attributes [optional]
     * @param string|null $connection [optional]
     *
     * @return static
     */
    public static function make(array $attributes = [], ?string $connection = null)
    {
        return (new static($attributes))
                    ->setConnection($connection);
    }

    /**
     * Returns the database table name for this model
     *
     * @see getTable
     *
     * @return string
     */
    public static function tableName(): string
    {
        return static::make()->getTable();
    }
}