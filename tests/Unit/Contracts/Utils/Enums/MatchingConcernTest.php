<?php

namespace Aedart\Tests\Unit\Contracts\Utils\Enums;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\BasicState;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\IntegerState;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\StringState;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * MatchingConcernTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Contracts\Utils\Enums
 */
#[Group(
    'contracts',
    'utils',
    'enums',
    'enums-matching-concern'
)]
class MatchingConcernTest extends UnitTestCase
{
    /**
     * Enums data provider
     *
     * @return array<string, array>
     */
    public function enums(): array
    {
        return [
            'Unit Enum - matches case (true)' => [ BasicState::OPEN, BasicState::OPEN, true ],
            'Unit Enum - matches case (false)' => [ BasicState::OPEN, BasicState::CLOSED, false ],
            'Unit Enum - matches other value (false)' => [ BasicState::OPEN, 'open', false ],
            'Unit Enum - matches other enum case (false)' => [ BasicState::OPEN, StringState::CLOSED, false ],

            'Backed Enum (string) - matches case (true)' => [ StringState::OPEN, StringState::OPEN, true ],
            'Backed Enum (string) - matches case (false)' => [ StringState::OPEN, StringState::CLOSED, false ],
            'Backed Enum (string) other value (true)' => [ StringState::OPEN, 'open', true ],
            'Backed Enum (string) other value (false)' => [ StringState::OPEN, 'closed', false ],
            'Backed Enum (string) other type of value (false)' => [ StringState::OPEN, [1, 2, 3], false ],
            'Backed Enum (string) - matches other enum case (false)' => [ StringState::OPEN, BasicState::CLOSED, false ],

            'Backed Enum (integer) - matches case (true)' => [ IntegerState::OPEN, IntegerState::OPEN, true ],
            'Backed Enum (integer) - matches case (false)' => [ IntegerState::OPEN, IntegerState::CLOSED, false ],
            'Backed Enum (integer) other value (true)' => [ IntegerState::OPEN, 10, true ],
            'Backed Enum (integer) other value (false)' => [ IntegerState::OPEN, 20, false ],
            'Backed Enum (integer) other type of value (false)' => [ IntegerState::OPEN, false, false ],
            'Backed Enum (integer) - matches other enum case (false)' => [ IntegerState::OPEN, BasicState::CLOSED, false ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param  BasicState|StringState|IntegerState  $enum
     * @param  mixed  $value
     * @param  bool  $expectation
     *
     * @return void
     */
    #[DataProvider('enums')]
    #[Test]
    public function canMatchAgainstValue(BasicState|StringState|IntegerState $enum, mixed $value, bool $expectation): void
    {
        $result = $enum->matches($value);

        ConsoleDebugger::output([
            'enum' => $enum::class,
            'value' => var_export($value, true),
            'expectation' => var_export($expectation, true),
            'result' => var_export($result, true),
        ]);

        $this->assertSame($expectation, $result);
    }
}
