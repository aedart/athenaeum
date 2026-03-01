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
     *
     * @throws JsonException
     */
    #[DataProvider('enums')]
    #[Test]
    public function canExportToJson(string $enumClass): void
    {
        $result = $enumClass::toJson(JSON_PRETTY_PRINT);

        ConsoleDebugger::output($result);

        $decoded = Json::decode($result, true);
        $keys = array_keys($decoded);
        $values = array_values($decoded);

        $this->assertEquals($enumClass::names(), $keys, 'incorrect keys');
        $this->assertEquals($enumClass::values(), $values, 'incorrect values');
    }
}
