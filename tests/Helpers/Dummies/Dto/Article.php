<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\ArrayDto;
use DateTimeInterface;
use Illuminate\Support\Carbon;

/**
 * Article
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property string|int|float|bool|null $id Article id
 * @property array|null $content Content
 * @property DateTimeInterface|Carbon|null $createdAt Datetime of when article was created
 * @property string|Person|Organisation|null $author Author of article
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Article extends ArrayDto
{
    protected array $allowed = [
        'id' => 'string|int|float|bool|null',
        'content' => 'array|null',
        'createdAt' => 'date|null',
        'author' => ['string', Person::class, Organisation::class, 'null'],
    ];
}
