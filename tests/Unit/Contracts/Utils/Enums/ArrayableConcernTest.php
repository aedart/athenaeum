<?php

namespace Aedart\Tests\Unit\Contracts\Utils\Enums;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\IntegerState;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\StringState;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ArrayableConcernTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Contracts\Utils\Enums
 */
#[Group(
    'contracts',
    'utils',
    'enums',
    'enums-arrayable-concern'
)]
class ArrayableConcernTest extends UnitTestCase
{
    /**
     * Enums data provider
     *
     * @return array<string, array>
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
    public function canExportToArray(string $enumClass): void
    {
        $result = $enumClass::toArray();

        ConsoleDebugger::output($result);

        $keys = array_keys($result);
        $values = array_values($result);

        $this->assertEquals($enumClass::names(), $keys, 'incorrect keys');
        $this->assertEquals($enumClass::values(), $values, 'incorrect values');
    }
}
