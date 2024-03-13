<?php

namespace Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Testing\Helpers\ConsoleDebugger;

/**
 * Amount Rule
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules
 */
class AmountRule implements ProcessingRule
{
    /**
     * @inheritDoc
     */
    public function process($item, Summation $summation): Summation
    {
        $result = $summation->increase('amount', 1);

        ConsoleDebugger::output('- - - - - - - - - - - - - - - - ');
        ConsoleDebugger::output('Amount Rule', $item['activity'], 'amount: ' . $result->get('amount'));

        return $result;
    }
}
