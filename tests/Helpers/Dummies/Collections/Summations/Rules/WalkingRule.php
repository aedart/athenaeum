<?php

namespace Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\Determinable;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Testing\Helpers\ConsoleDebugger;

/**
 * Walking Rule
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules
 */
class WalkingRule implements
    ProcessingRule,
    Determinable
{
    /**
     * @inheritDoc
     */
    public function canProcess(mixed $item): bool
    {
        return isset($item['activity']) && $item['activity'] === 'walking';
    }

    /**
     * @inheritDoc
     */
    public function process(mixed $item, Summation $summation): Summation
    {
        $result = $summation->increase('points', 2);

        ConsoleDebugger::output('Walking Rule (2 points).', $item['activity'], 'Points: ' . $result->get('points'));

        return $result;
    }
}
