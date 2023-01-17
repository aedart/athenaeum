<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;
use Aedart\Redmine\Partials\Journals\Detail;
use Aedart\Redmine\Partials\Journals\ListOfDetails;
use Carbon\Carbon;

/**
 * Journal Entry
 *
 * @property int $id
 * @property Reference $user
 * @property string $notes
 * @property bool $private_notes
 * @property ListOfDetails<Detail>|Detail[]|null $details
 * @property Carbon $created_on
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class Journal extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
        'user' => Reference::class,
        'notes' => 'string',
        'private_notes' => 'bool',
        'details' => ListOfDetails::class,
        'created_on' => 'date'
    ];
}
