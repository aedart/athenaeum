<?php

namespace Aedart\Tests\Integration\Database\Query\Concerns;

use Aedart\Database\Query\Concerns\Joins;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * JoinsConcernTest
 *
 * @group database
 * @group db
 * @group db-query
 * @group db-query-concerns
 * @group query-joins-concern
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Database\Query\Concerns
 */
#[Group(
    'db',
    'database',
    'db-query',
    'db-query-concerns',
    'query-joins-concern',
)]
class JoinsConcernTest extends DatabaseTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a class what uses desired concern
     *
     * @return object
     */
    public function makeConcern()
    {
        return new class() {
            use Joins;
        };
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsFalseWhenQueryHasNoJoins(): void
    {
        $query = Category::query();

        $result = $this->makeConcern()
            ->hasJoinTo($query, 'some_table');

        $this->assertFalse($result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsTrueWhenQueryHasJoinExpressionToTable(): void
    {
        $table = 'owners';

        $query = Category::query()
            ->join($table, 'id', '=', 'owner_id');

        // ------------------------------------------------------------ //

        $result = $this->makeConcern()
            ->hasJoinTo($query, $table);

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsFalseWhenNotJoinExpressionToDesiredTable(): void
    {
        $query = Category::query()
            ->join('owners', 'id', '=', 'owner_id');

        // ------------------------------------------------------------ //

        $result = $this->makeConcern()
            ->hasJoinTo($query, 'stores');

        $this->assertFalse($result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function appliesJoinWhenNotAlreadyJoinedToTable(): void
    {
        $concern = $this->makeConcern();
        $query = Category::query();

        $query = $concern
            ->safeJoin($query, 'owners', 'id', '=', 'owner_id');

        $this->assertTrue($concern->hasJoinTo($query, 'owners'));
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function doesNotApplyJoinIfAlreadyJoinedToTable(): void
    {
        $concern = $this->makeConcern();
        $query = Category::query()
            ->join('owners', 'id', '=', 'owner_id');

        $query = $concern
            ->safeJoin($query, 'owners', 'id', '=', 'owner_id');

        $this->assertTrue($concern->hasJoinTo($query, 'owners'));

        $this->assertCount(1, $query->getQuery()->joins, 'Too many join expressions added');
    }
}
