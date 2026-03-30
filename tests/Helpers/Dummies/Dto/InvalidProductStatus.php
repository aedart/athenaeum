<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

/**
 * Invalid Product Status
 *
 * FOR TESTING PURPOSES...
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
enum InvalidProductStatus
{
    case DRAFT;
    case PUBLISHED;
    case UNPUBLISHED;
    case UNDER_REVIEW;
}
