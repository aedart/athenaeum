<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\ArrayDto;

/**
 * Product
 *
 * FOR TESTING ONLY...
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property ProductStatus $status
 * @property Availability|null $availability
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Product extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'status' => ProductStatus::class,
        'availability' => [ Availability::class, 'null' ],
    ];
}
