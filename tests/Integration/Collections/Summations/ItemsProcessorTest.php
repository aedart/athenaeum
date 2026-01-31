<?php

namespace Aedart\Tests\Integration\Collections\Summations;

use Aedart\Collections\Summations\ItemsProcessor;
use Aedart\Collections\Summations\Rules\NullProcessingRule;
use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\ItemsProcessor as ItemsProcessorInterface;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Repository;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules\AmountRule;
use Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules\PauseRule;
use Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules\RunningRule;
use Aedart\Tests\Helpers\Dummies\Collections\Summations\Rules\WalkingRule;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ItemsProcessorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Collections\Summations
 */
#[Group(
    'collections',
    'summations',
    'items-processor',
)]
class ItemsProcessorTest extends IntegrationTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Items Processor instance
     *
     * @param  ProcessingRule[]|string[]|Repository  $rules Processing Rules instances, class paths or Repository of
     *                                                processing rules.
     * @param  Summation|null  $summation  [optional]
     *
     * @return ItemsProcessorInterface
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function makeProcessor($rules, ?Summation $summation = null): ItemsProcessorInterface
    {
        return new ItemsProcessor($rules, $summation);
    }

    /**
     * Returns a list of "activity" records
     *
     * @see makeActivityRecord
     *
     * @return array
     */
    public function activities(): array
    {
        // See rules to be applied in tests...
        return [
            $this->makeActivityRecord('running'), // 5 points
            $this->makeActivityRecord('walking'), // 2 points
            $this->makeActivityRecord('pause'),   // -1 points
            $this->makeActivityRecord('running'), // 5 points
            $this->makeActivityRecord('running'), // 5 points
            $this->makeActivityRecord('walking'), // 2 points
            $this->makeActivityRecord('pause'),   // -1 points
            $this->makeActivityRecord('running'), // 5 points
            $this->makeActivityRecord('running'), // 5 points
            $this->makeActivityRecord('walking'), // 2 points (29 points total)
        ];
    }

    /**
     * Returns an "activity record" of sorts.
     *
     * Intended to represent a "typical" record to process, from
     * an external data source, like a database or csv file.
     *
     * @param  string  $activity
     *
     * @return string[]
     */
    public function makeActivityRecord(string $activity): array
    {
        return [
            'activity' => $activity,
        ];
    }

    /**
     * Returns a list of "activity" records
     *
     * @see makeActivityRecord
     *
     * @param  int  $amount  [optional]
     *
     * @return \Generator
     */
    public function yieldedActivities(int $amount = 10)
    {
        while ($amount--) {
            yield $this->makeActivityRecord('running');
        }
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function canObtainInstance()
    {
        $processor = $this->makeProcessor([ new NullProcessingRule() ]);

        $this->assertNotNull($processor);
    }

    #[Test]
    public function canProcessItems()
    {
        // Create new processor with given rules (testing if they can be resolved...)
        $processor = $this->makeProcessor([
            WalkingRule::class,
            new AmountRule(),
            RunningRule::class,
            new PauseRule()
        ]);

        // Process items... apply before / after callbacks
        $results = $processor
            ->before(function (Summation $summation) {
                return $summation
                    ->set('amount', 0)
                    ->set('points', 0);
            })
            ->after(function (Summation $summation) {
                return $summation
                    ->set('average', function ($value, Summation $summation) {
                        return $summation->get('points') / $summation->get('amount');
                    });
            })
            ->process($this->activities());

        ConsoleDebugger::output($results);

        $this->assertSame(10, $results->get('amount'));
        $this->assertSame(29, $results->get('points'));
        $this->assertSame(2.9, $results->get('average'));
    }

    #[Test]
    public function canProcessYieldedItems()
    {
        // Create new processor with given rules (testing if they can be resolved...)
        $processor = $this->makeProcessor([
            RunningRule::class,
        ]);

        // Process items... apply before / after callbacks
        $results = $processor
            ->before(function (Summation $summation) {
                return $summation
                    ->set('points', 0);
            })
            ->process($this->yieldedActivities());

        ConsoleDebugger::output($results);

        $this->assertSame(50, $results->get('points'));
    }
}
