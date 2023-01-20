<?php

namespace Aedart\Tests\Integration\Database\Utils;

use Aedart\Database\Utils\Database;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;

/**
 * DatabaseUtilsTest
 *
 * @group database
 * @group db
 * @group db-utils
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Database\Utils
 */
class DatabaseUtilsTest extends DatabaseTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canDetermineDriver(): void
    {
        $query = Category::query();

        $result = Database::determineDriver($query);
        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }
}