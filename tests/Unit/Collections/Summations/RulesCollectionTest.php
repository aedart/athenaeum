<?php

namespace Aedart\Tests\Unit\Collections\Summations;

use Aedart\Collections\Summation as SummationCollection;
use Aedart\Collections\Summations\Rules\RulesCollection;
use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Rules;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use Mockery as m;
use PHPUnit\Framework\Attributes\Test;

/**
 * RulesCollectionTest
 *
 * @group collections
 * @group summations
 * @group rules-collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Collections\Summations
 */
#[Group(
    'collections',
    'summations',
    'rules-collection'
)]
class RulesCollectionTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Rules Collection instance
     *
     * @param  mixed $item  [optional]
     * @param  ProcessingRule[]  $rules  [optional]
     * @param  Summation|null  $summation  [optional]
     *
     * @return Rules
     */
    public function makeCollection($item = null, array $rules = [], ?Summation $summation = null): Rules
    {
        $item = $item ?? $this->makeItemMock();
        $summation = $summation ?? $this->makeSummationCollection();

        return new RulesCollection($item, $rules, $summation);
    }

    /**
     * Creates a new Summation Collection instance
     *
     * @return Summation
     */
    public function makeSummationCollection(): Summation
    {
        return SummationCollection::make();
    }

    /**
     * Creates a mocked Processing Rule
     *
     * @return ProcessingRule|m\LegacyMockInterface|m\MockInterface
     */
    public function makeProcessingRuleMock()
    {
        return m::mock(ProcessingRule::class);
    }

    /**
     * Creates a list of mocked Processing Rules
     *
     * @param  int  $amount  [optional]
     * @param  callable|null  $callback  [optional] Callback to apply on all mocks.
     *                                   Mock instance is given as method argument.
     *
     * @return ProcessingRule[]|m\LegacyMockInterface[]|m\MockInterface[]
     */
    public function makeProcessingRuleMocks(int $amount = 3, ?callable $callback = null): array
    {
        // Resolve callback
        $callback = $callback ?? function ($mock) {
            return $mock;
        };

        $output = [];

        while ($amount--) {
            $output[] = $callback($this->makeProcessingRuleMock());
        }

        return $output;
    }

    /**
     * Creates a new mocked "item"
     *
     * @return m\LegacyMockInterface|m\MockInterface
     */
    public function makeItemMock()
    {
        return m::mock();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function canObtainInstance()
    {
        $collection = $this->makeCollection();

        $this->assertNotNull($collection);
    }

    /**
     * @test
     */
    #[Test]
    public function canObtainItem()
    {
        $item = $this->makeItemMock();

        $result = $this->makeCollection($item)
            ->item();

        $this->assertSame($item, $result);
    }

    /**
     * @test
     */
    #[Test]
    public function canCreateNewInstanceWithItem()
    {
        $item = $this->makeItemMock();

        $collectionA = $this->makeCollection();
        $collectionB = $collectionA
            ->withItem($item);

        $this->assertSame($item, $collectionB->item());
        $this->assertNotSame($collectionA, $collectionB);
    }

    /**
     * @test
     */
    #[Test]
    public function canObtainSummationCollection()
    {
        $summation = $this->makeSummationCollection();

        $result = $this->makeCollection(null, [], $summation)
            ->summation();

        $this->assertSame($summation, $result);
    }

    /**
     * @test
     */
    #[Test]
    public function canCreateNewInstanceWithSummation()
    {
        $summation = $this->makeSummationCollection();

        $collectionA = $this->makeCollection();
        $collectionB = $collectionA
            ->withSummation($summation);

        $this->assertSame($summation, $collectionB->summation());
        $this->assertNotSame($collectionA, $collectionB);
    }

    /**
     * @test
     */
    #[Test]
    public function canObtainRules()
    {
        $rules = $this->makeProcessingRuleMocks();

        $result = $this->makeCollection(null, $rules)
            ->rules();

        $this->assertSame($rules, $result);
    }

    /**
     * @test
     */
    #[Test]
    public function canCreateNewInstanceWithRules()
    {
        $rules = $this->makeProcessingRuleMocks();

        $collectionA = $this->makeCollection();
        $collectionB = $collectionA
            ->withRules($rules);

        $this->assertSame($rules, $collectionB->rules());
        $this->assertNotSame($collectionA, $collectionB);
    }

    /**
     * @test
     */
    #[Test]
    public function canExportToArray()
    {
        $rules = $this->makeProcessingRuleMocks();

        $result = $this->makeCollection(null, $rules)
            ->toArray();

        $this->assertSame($rules, $result);
    }

    /**
     * @test
     */
    #[Test]
    public function canLoopThroughRules()
    {
        $rules = $this->makeProcessingRuleMocks();

        $collection = $this->makeCollection(null, $rules);

        $c = 0;
        foreach ($collection as $rule) {
            $this->assertContains($rule, $rules);
            $c++;
        }

        $this->assertSame(count($rules), $c, 'Incorrect amount looped through');
    }

    /**
     * @test
     */
    #[Test]
    public function canCountRulesInCollection()
    {
        $collection = $this->makeCollection(null, $this->makeProcessingRuleMocks(5));

        $this->assertCount(5, $collection);
        $this->assertSame(5, $collection->count(), 'Incorrect amount via count()');
    }

    /**
     * @test
     */
    #[Test]
    public function canProcessRules()
    {
        $item = $this->makeItemMock();
        $summation = $this->makeSummationCollection();
        $amountRulesInvoked = 0;

        $rules = $this->makeProcessingRuleMocks(3, function (m\MockInterface $mock) use ($item, $summation, &$amountRulesInvoked) {
            return $mock
                ->shouldReceive('process')
                ->once()
                ->with($item, $summation)
                ->andReturnUsing(function () use ($summation, &$amountRulesInvoked) {
                    ConsoleDebugger::output('Invoking Processing Rule...');
                    $amountRulesInvoked++;

                    return $summation;
                })
                ->getMock();
        });

        $collection = $this->makeCollection($item, $rules, $summation);

        $result = $collection->process();

        // Note: In this case we use same Summation instance, but in real situations
        // the instance might be overwritten by a processing rule.
        $this->assertSame($summation, $result);
        $this->assertSame(3, $amountRulesInvoked, 'Incorrect amount of rules invoked');
    }
}
