<?php

namespace Aedart\Tests\Integration\Validation\Concerns;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Validation\Failure;
use Aedart\Tests\TestCases\Validation\ValidationTestCase;
use Aedart\Validation\Rules\Concerns\ValidationFailure;

/**
 * ValidationFailureTest
 *
 * @group validation
 * @group validation-concerns
 * @group validation-failure-state
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Validation\Concerns
 */
class ValidationFailureTest extends ValidationTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns class that uses validation failure concern
     *
     * @return object
     */
    public function makeConcern()
    {
        return new class() {
            use ValidationFailure;
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
    public function canSetAndObtainFailureState(): void
    {
        $state = Failure::NOT_INPUT;

        $concern = $this->makeConcern();

        $result = $concern
            ->setFailedState($state)
            ->getFailedState();

        ConsoleDebugger::output($result);

        $this->assertTrue($concern->hasFailedState(), 'No failed state was set');
        $this->assertSame($state, $result);
    }
}
