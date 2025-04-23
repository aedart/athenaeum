<?php

namespace Aedart\Tests\Integration\Database\Utils;

use Aedart\Database\Utils\Database;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * DatabaseUtilsTest
 *
 * @group database
 * @group db
 * @group db-utils
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Database\Utils
 */
#[Group(
    'db',
    'database',
    'db-utils',
)]
class DatabaseUtilsTest extends DatabaseTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canDetermineDriver(): void
    {
        $query = Category::query();

        $result = Database::determineDriver($query);
        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canPrefixColumns(): void
    {
        $prefix = 'games';
        $columns = [
            'name',
            'price',
            fn () => true,
        ];

        $result = Database::prefixColumns($columns, $prefix);

        // dump($result);
        // ConsoleDebugger::output($result); // WARNING: debugger causes memory leak due to closure

        $this->assertCount(3, $columns);

        $this->assertIsCallable($result[2], 'Callback not returned');
        $this->assertTrue(in_array('games.name', $result), 'name not prefixed');
        $this->assertTrue(in_array('games.price', $result), 'price not prefixed');
    }
}
