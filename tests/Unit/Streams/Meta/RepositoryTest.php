<?php

namespace Aedart\Tests\Unit\Streams\Meta;

use Aedart\Contracts\Streams\Meta\Repository as RepositoryInterface;
use Aedart\Streams\Meta\Repository;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * RepositoryTest
 *
 * @group streams
 * @group streams-meta
 * @group streams-meta-repository
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Streams\Meta
 */
#[Group(
    'streams',
    'streams-meta',
    'streams-meta-repository'
)]
class RepositoryTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a new meta repository instance
     *
     * @param  array  $data  [optional]
     *
     * @return RepositoryInterface
     */
    public function makeRepository(array $data = []): RepositoryInterface
    {
        return new Repository($data);
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
    public function canObtainInstance()
    {
        $repo = $this->makeRepository();

        $this->assertNotNull($repo);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canSetAndObtainMeta()
    {
        $repo = $this->makeRepository();

        $key = 'aaa.bbb';
        $value = 'meta-value';

        $result = $repo
            ->set($key, $value)
            ->get($key);

        $this->assertTrue($repo->has($key));
        $this->assertSame($value, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsDefaultValue()
    {
        $repo = $this->makeRepository();

        $default = 'meta-value';

        $result = $repo
            ->get('unknown', $default);

        $this->assertSame($default, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canRemoveMeta()
    {
        $repo = $this->makeRepository();

        $key = 'aaa.bbb';

        $result = $repo
            ->set($key, 'meta-value')
            ->remove($key);

        $this->assertTrue($result, 'Key was not removed');
        $this->assertFalse($repo->has($key), 'Key still exists in repository');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canMergeNewMetaIntoRepository()
    {
        $repo = $this->makeRepository([
            'a' => 1,
            'b' => 2,
            'c' => 3
        ]);

        $repo->populate([
            'a' => true,
            'd' => 4
        ]);

        $this->assertSame(true, $repo->get('a'));
        $this->assertSame(4, $repo->get('d'));
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainAllMeta()
    {
        $repo = $this->makeRepository([
            'a' => 1,
            'b' => 2,
            'c.a' => 3
        ]);

        $all = $repo->toArray();

        ConsoleDebugger::output($all);

        $this->assertCount(3, $all);
        $this->assertArrayHasKey('c', $all);
        $this->assertIsArray($all['c']);
        $this->assertArrayHasKey('a', $all['c']);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canUseArrayAccessOnRepository()
    {
        $repo = $this->makeRepository();

        $key = 'bbb.ddd.aaa';
        $value = 'meta-value';

        $repo[$key] = $value;
        $this->assertArrayHasKey($key, $repo);
        $this->assertTrue(isset($repo[$key]));
        $this->assertSame($value, $repo[$key]);

        // ------------------------------------------------- //

        unset($repo[$key]);

        $this->assertArrayNotHasKey($key, $repo);
        $this->assertFalse(isset($repo[$key]));
    }
}
