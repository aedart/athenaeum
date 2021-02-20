<?php

namespace Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\Determinable;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Testing\Helpers\ConsoleDebugger;

/**
 * Running Rule
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules
 */
class RunningRule implements
    ProcessingRule,
    Determinable
{
    /**
     * @inheritDoc
     */
    public function canProcess($item): bool
    {
        return isset($item['activity']) && $item['activity'] === 'running';
    }

    /**
     * @inheritDoc
     */
    public function process($item, Summation $summation): Summation
    {
        $result = $summation->increase('points', 5);

        ConsoleDebugger::output('Running Rule (5 points).', $item['activity'], 'Points: ' . $result->get('points'));

        return $result;
    }
}
