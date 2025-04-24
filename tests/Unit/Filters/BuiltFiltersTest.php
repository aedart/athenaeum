<?php

namespace Aedart\Tests\Unit\Filters;

use Aedart\Contracts\Database\Query\Criteria;
use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BuiltFilters;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Database\Query\Filters\GenericFilter;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * BuiltFiltersTest
 *
 * @group filters
 * @group built-filters-map
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Filters
 */
#[Group(
    'filters',
    'built-filters-map',
)]
class BuiltFiltersTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new built filters map instance
     *
     * @param array $filters [optional]
     * @param array $meta [optional]
     *
     * @return BuiltFiltersMap
     */
    public function makeMap(array $filters = [], array $meta = []): BuiltFiltersMap
    {
        return new BuiltFilters($filters, $meta);
    }

    /**
     * Creates a new criteria (query filter) instance
     *
     * @return Criteria
     *
     * @throws CriteriaException
     */
    public function makeCriteria(): Criteria
    {
        return new GenericFilter($this->getFaker()->unique()->slug(3));
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws CriteriaException
     */
    #[Test]
    public function canAddAndRetrieveFilter()
    {
        $map = $this->makeMap();

        $key = 'my-filter';
        $filter = $this->makeCriteria();

        $map->add($key, $filter);

        $this->assertTrue($map->has($key));

        // -------------------------------------------- //
        // Output is a list of filters.
        $result = $map->get($key);

        $this->assertCount(1, $result);
        $this->assertSame($filter, $result[0]);
    }

    /**
     * @test
     *
     * @throws CriteriaException
     */
    #[Test]
    public function returnsDefaultWhenNoFilterAdded()
    {
        $map = $this->makeMap();

        $key = 'my-filter';
        $default = [$this->makeCriteria()];

        $result = $map->get($key, $default);

        $this->assertSame($default, $result);
    }

    /**
     * @test
     *
     * @throws CriteriaException
     */
    #[Test]
    public function canObtainAllFilters()
    {
        $map = $this->makeMap();

        $keyA = 'my-filter';
        $keyB = 'my-filter';
        $filterA = $this->makeCriteria();
        $filterB = $this->makeCriteria();
        $expected = [ $filterA, $filterB ];

        $map
            ->add($keyA, $filterA)
            ->add($keyB, $filterB);

        $result = $map->all();

        $this->assertCount(2, $result);

        foreach ($result as $filter) {
            $this->assertTrue(in_array($filter, $expected));
        }
    }

    /**
     * @test
     *
     * @throws CriteriaException
     */
    #[Test]
    public function canForgetFilters()
    {
        $map = $this->makeMap();

        $key = 'my-filter';
        $filterA = $this->makeCriteria();
        $filterB = $this->makeCriteria();

        $map
            ->add($key, $filterA)
            ->add($key, $filterB);


        $this->assertTrue($map->has($key));

        // -------------------------------------------- //
        // Forget should clear all filters

        $map->forget($key);

        $this->assertFalse($map->has($key));
    }

    /**
     * @test
     */
    #[Test]
    public function canSetAndObtainMeta()
    {
        $map = $this->makeMap();

        $key = 'my-filter';
        $value = $this->getFaker()->slug();

        $map->setMeta($key, $value);

        $this->assertTrue($map->hasMeta($key));

        $result = $map->getMeta($key);
        $this->assertSame($value, $result);
    }

    /**
     * @test
     */
    #[Test]
    public function returnsDefaultWhenNoMetaSet()
    {
        $map = $this->makeMap();

        $key = 'my-filter';
        $default = $this->getFaker()->slug();

        $result = $map->getMeta($key, $default);

        $this->assertSame($default, $result);
    }

    /**
     * @test
     */
    #[Test]
    public function canForgetMeta()
    {
        $map = $this->makeMap();

        $key = 'my-filter';
        $value = $this->getFaker()->slug();

        $map->setMeta($key, $value);

        $this->assertTrue($map->hasMeta($key));

        // ------------------------------------------------ //

        $map->forgetMeta($key);
        $this->assertFalse($map->hasMeta($key));
    }

    /**
     * @test
     */
    #[Test]
    public function canObtainAllMeta()
    {
        $map = $this->makeMap();

        $keyA = 'my-filter';
        $keyB = 'my-other-filter';
        $valueA = $this->getFaker()->slug();
        $valueB = $this->getFaker()->slug();

        $map
            ->setMeta($keyA, $valueA)
            ->setMeta($keyB, $valueB);

        $meta = $map->meta();

        $this->assertCount(2, $meta);
        $this->assertArrayHasKey($keyA, $meta);
        $this->assertArrayHasKey($keyB, $meta);
    }

    /**
     * @test
     *
     * @throws CriteriaException
     */
    #[Test]
    public function canForgetAll()
    {
        $map = $this->makeMap();

        $keyA = 'my-filter';
        $keyB = 'my-other-filter';

        $filterA = $this->makeCriteria();
        $filterB = $this->makeCriteria();

        $valueA = $this->getFaker()->slug();
        $valueB = $this->getFaker()->slug();

        $map
            ->add($keyA, $filterA)
            ->add($keyB, $filterB)
            ->setMeta($keyA, $valueA)
            ->setMeta($keyB, $valueB);

        $map->forgetAll();

        $this->assertFalse($map->has($keyA));
        $this->assertFalse($map->has($keyB));
        $this->assertFalse($map->hasMeta($keyA));
        $this->assertFalse($map->hasMeta($keyB));
    }
}
