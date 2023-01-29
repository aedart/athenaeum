<?php


namespace Aedart\Database\Models\Concerns;

/**
 * Concerns Database Table
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Database\Models\Concerns
 */
trait Table
{
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
