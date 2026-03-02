<?php

namespace Aedart\Tests\Unit\Contracts\Utils\Enums;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\BasicState;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\IntegerState;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\StringState;
use BackedEnum;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ValuesConcernTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Contracts\Utils\Enums
 */
#[Group(
    'contracts',
    'utils',
    'enums',
    'enums-values-concern'
)]
class ValuesConcernTest extends UnitTestCase
{
    /**
     * Enums data provider
     *
     * @return array<string, class-string<BackedEnum>[]>
     */
    public function enums(): array
    {
        return [
            'Backed Enum (string)' => [ StringState::class ],
            'Backed Enum (integer)' => [ IntegerState::class ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param  class-string<StringState|IntegerState>  $enumClass
     *
     * @return void
     */
    #[DataProvider('enums')]
    #[Test]
    public function canListValues(string $enumClass): void
    {
        $values = $enumClass::values();

        ConsoleDebugger::output($values);

        $this->assertCount(count(BasicState::cases()), $values, 'Incorrect number of values');
    }
}
