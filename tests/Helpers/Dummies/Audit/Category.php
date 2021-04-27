<?php


namespace Aedart\Tests\Helpers\Dummies\Audit;

use Aedart\Audit\Traits\RecordsChanges;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category as BaseCategory;

/**
 * Category
 *
 * FOR TESTING ONLY
 *
 * @see \Aedart\Tests\Helpers\Dummies\Database\Models\Category
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Audit
 */
class Category extends BaseCategory
{
    use RecordsChanges;
}