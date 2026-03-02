<?php

namespace Aedart\Tests\Unit\Contracts\Utils\Enums;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\IntegerState;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\StringState;
use Aedart\Utils\Json;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * JsonableConcernTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Contracts\Utils\Enums
 */
#[Group(
    'contracts',
    'utils',
    'enums',
    'enums-jsonable-concern'
)]
class JsonableConcernTest extends UnitTestCase
{
    /**
     * Enums data provider
     *
     * @return array<string, array>
     */
    public function enums(): array
    {
        return [
            'Backed Enum (string)' => [ StringState::OPEN, '"open"' ],
            'Backed Enum (integer)' => [ IntegerState::CLOSED, '20' ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param  StringState|IntegerState  $enum
     * @param  int|string $expected
     *
     * @return void
     *
     * @throws JsonException
     */
    #[DataProvider('enums')]
    #[Test]
    public function canExportToJson(StringState|IntegerState $enum, int|string $expected): void
    {
        $result = $enum->toJson();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
