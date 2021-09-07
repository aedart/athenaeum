<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Child Issue Reference
 *
 * @property int $id
 * @property Reference $tracker
 * @property string $subject
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ChildIssueReference extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
        'tracker' => Reference::class,
        'subject' => 'string'
    ];
}
