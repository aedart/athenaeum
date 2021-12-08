<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Models;

use Aedart\Database\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Owner
 *
 * @property int $id Unique identifier
 * @property string $name Name of owner
 * @property int $category_id Foreign key
 *
 * @property-read Category|null $category
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Models
 */
class Owner extends Model
{
    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Category this owner owns...
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}