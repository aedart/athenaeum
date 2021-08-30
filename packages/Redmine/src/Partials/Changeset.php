<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;
use Aedart\Redmine\Relation;
use Carbon\Carbon;

/**
 * Changeset
 *
 * @property string $revision
 * @property Relation $user
 * @property string $comments
 * @property Carbon $committed_on
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class Changeset extends ArrayDto
{
    protected array $allowed = [
        'revision' => 'string',
        'user' => Relation::class,
        'comments' => 'string',
        'committed_on' => 'date'
    ];
}
