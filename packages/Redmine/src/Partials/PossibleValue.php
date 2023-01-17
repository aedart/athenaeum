<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Possible Value (Custom Fields)
 *
 * @property string $value
 * @property string $label
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class PossibleValue extends ArrayDto
{
    protected array $allowed = [
        'value' => 'string',
        'label' => 'string'
    ];
}
