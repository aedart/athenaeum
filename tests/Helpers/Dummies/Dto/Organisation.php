<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\ArrayDto;
use Aedart\Tests\Helpers\Dummies\Contracts\Note;
use Carbon\Carbon;

/**
 * Organisation DTO
 *
 * FOR TESTING ONLY
 *
 * @property string|null $name
 * @property string|null $slogan
 * @property int|null $employees
 * @property bool|null $hasInsurance
 * @property float|null $profitScore
 * @property array|null $persons
 * @property Carbon|null $started
 * @property Address|null $address
 * @property Note|null $note
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Organisation extends ArrayDto
{
    protected array $allowed = [
        'name' => 'string',
        'slogan' => 'string',
        'employees' => 'int',
        'hasInsurance' => 'bool',
        'profitScore' => 'float',
        'persons' => 'array',
        'started' => 'date',
        'address' => Address::class,
        'note' => Note::class
    ];

    public function setSlogan(?string $slogan)
    {
        $this->properties['slogan'] = strtoupper($slogan);

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->properties['slogan'] ?? null;
    }
}
