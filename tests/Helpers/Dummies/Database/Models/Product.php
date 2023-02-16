<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Models;

use Aedart\Database\Model;
use Aedart\Database\Models\Concerns\Filtering;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Product
 *
 * @property int $id Product id
 * @property int|null $category_id Foreign key - category this product belongs to
 * @property string $name Name of product
 * @property string|null $description Evt. description of product
 * @property int|null $restricted_to_owner_id Foreign key - product is restricted to given owner
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 * @property Carbon|null $deleted_at Evt. date and time of when record was soft-deleted
 *
 * @property-read Category|null $category The category this product belongs to
 * @property-read Owner|null $restrictedOwner Owner restriction
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Models
 */
class Product extends Model
{
    use Filtering;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * The category this product belongs to
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Owner restriction
     *
     * @return BelongsTo
     */
    public function restrictedOwner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'restricted_to_owner_id');
    }
}
