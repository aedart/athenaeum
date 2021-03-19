<?php

namespace Aedart\Database;

use Aedart\Contracts\Database\Models\Instantiatable;
use Aedart\Database\Models\Concerns;
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
abstract class Model extends BaseModel implements Instantiatable
{
    use Concerns\Instance;

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