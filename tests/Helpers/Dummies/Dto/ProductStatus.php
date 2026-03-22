<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Product Status
 *
 * FOR TESTING ONLY...
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
enum ProductStatus: string
{
    use Concerns\BackedEnums;

    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
    case UNDER_REVIEW = 'review';
}
